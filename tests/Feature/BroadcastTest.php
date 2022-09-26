<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use ProcessMaker\Events\ActivityAssigned;
use ProcessMaker\Events\ActivityCompleted;
use ProcessMaker\Events\BuildScriptExecutor;
use ProcessMaker\Events\ImportedScreenSaved;
use ProcessMaker\Events\MarkArtisanCachesAsInvalid;
use ProcessMaker\Events\ModelerStarting;
use ProcessMaker\Events\ProcessCompleted;
use ProcessMaker\Events\ProcessUpdated;
use ProcessMaker\Events\ScreenBuilderStarting;
use ProcessMaker\Events\ScriptResponseEvent;
use ProcessMaker\Events\SessionStarted as SessionStartedEvent;
use ProcessMaker\Events\TestStatusEvent;
use ProcessMaker\Managers\ModelerManager as Modeler;
use ProcessMaker\Managers\ScreenBuilderManager;
use ProcessMaker\Managers\ScreenBuilderManager as ScreenBuilder;
use ProcessMaker\Models\ProcessRequest as Request;
use ProcessMaker\Models\ProcessRequestToken as Task;
use ProcessMaker\Models\Screen;
use ProcessMaker\Models\User;
use Tests\Feature\Shared\LoggingHelper;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class BroadcastTest extends TestCase
{
    use LoggingHelper;
    use WithFaker;

    public function testBroadcastEventsHaveTesting()
    {
        foreach (scandir(app_path('Events')) as $file) {
            if (!preg_match('/(?<name>.+).php/', $file, $matches)) {
                continue;
            }

            $name = $matches['name'];
            $methodName = "test{$name}Broadcast";
            $this->assertTrue(method_exists($this, $methodName), "Failed asserting that broadcast event {$name} has a test.");
        }
    }

    /**
     * Test that the MarkSettingsCacheAsInvalid event was fired after a setting change.
     */
    public function testMarkArtisanCachesAsInvalidBroadcast()
    {
        // Fake event MarkArtisanCachesAsInvalid
        Event::fake([
            MarkArtisanCachesAsInvalid::class
        ]);

        // Call refresh artisan caches taht triggers the event 'MarkArtisanCachesAsInvalid'
        refresh_artisan_caches();

        // Assert event was dispatched
        Event::assertDispatched(MarkArtisanCachesAsInvalid::class);
    }

    /**
     * Asserts that the ActivityAssigned broadcast event works.
     */
    public function testActivityAssignedBroadcast()
    {
        $task = factory(Task::class)->create([
            'data' => [
                'test' => $this->faker->text(20000),
            ],
        ]);

        event(new ActivityAssigned($task));
        $this->assertLogContainsText('ActivityAssigned');
        $this->assertLogContainsText(addcslashes(route('api.tasks.show', ['task' => $task->id]), '/'));
        $this->assertBroadcastEventSizeLessThan('ActivityAssigned', 10000);
    }

    /**
     * Asserts that the ActivityCompleted broadcast event works.
     */
    public function testActivityCompletedBroadcast()
    {
        $task = factory(Task::class)->create([
            'data' => [
                'test' => $this->faker->text(20000),
            ],
        ]);
        event(new ActivityCompleted($task));
        $this->assertLogContainsText('ActivityCompleted');
        $this->assertLogContainsText(addcslashes(route('api.tasks.show', ['task' => $task->id]), '/'));
        $this->assertBroadcastEventSizeLessThan('ActivityCompleted', 10000);
    }

    /**
     * Asserts that the ProcessCompleted broadcast event works.
     */
    public function testProcessCompletedBroadcast()
    {
        $request = factory(Request::class)->create([
            'data' => [
                'test' => $this->faker->text(20000),
            ],
        ]);
        event(new ProcessCompleted($request));
        $this->assertLogContainsText('ProcessCompleted');
        $this->assertLogContainsText(addcslashes(route('api.requests.show', [$request->id]), '/'));
        $this->assertBroadcastEventSizeLessThan('ProcessCompleted', 10000);
    }

    /**
     * Asserts that the ProcessUpdated broadcast event works.
     */
    public function testProcessUpdatedBroadcast()
    {
        $request = factory(Request::class)->create([
            'data' => [
                'test' => $this->faker->text(20000),
            ],
        ]);
        event(new ProcessUpdated($request, 'ACTIVITY_COMPLETED'));
        $this->assertLogContainsText('ProcessUpdated');
        $this->assertLogContainsText(addcslashes(route('api.requests.show', [$request->id]), '/'));
        $this->assertBroadcastEventSizeLessThan('ProcessUpdated', 10000);
    }

    /**
     * Asserts that the ScreenBuilderStarting broadcast event works.
     */
    public function testScreenBuilderStartingBroadcast()
    {
        $this->expectsEvents([
            ScreenBuilderStarting::class,
        ]);
        $manager = new ScreenBuilder();
        event(new ScreenBuilderStarting($manager, 'DISPLAY'));
    }

    /**
     * Asserts that the ScreenBuilderStarting broadcast event works.
     */
    public function testModelerStartingBroadcast()
    {
        $this->expectsEvents([
            ModelerStarting::class,
        ]);
        $manager = new Modeler();
        event(new ModelerStarting($manager));
    }

    /**
     * Asserts that the SessionStart broadcast event works.
     */
    public function testSessionStartedBroadcast()
    {
        $user = factory(User::class)->create();
        event(new SessionStartedEvent($user));

        $this->assertLogContainsText('SessionStarted');
        $this->assertBroadcastEventSizeLessThan('SessionStarted', 10000);
    }

    /**
     * Asserts that the BuildScriptExecutor event works.
     */
    public function testBuildScriptExecutorBroadcast()
    {
        $user = factory(User::class)->create();
        event(new BuildScriptExecutor('output-text', $user->id, 'output-status'));

        $this->assertLogContainsText('output-text');
        $this->assertLogContainsText((string) $user->id);
        $this->assertLogContainsText('output-status');
    }

    /**
     * Asserts that the ScreenBuilderStarting broadcast event works.
     */
    public function testScriptBuilderStartingBroadcast()
    {
        $this->expectsEvents([
            ScreenBuilderStarting::class,
        ]);
        $manager = new ScreenBuilderManager();
        $type = 'FORM';
        event(new ScreenBuilderStarting($manager, $type));
    }

    /**
     * Asserts that the BuildScriptExecutor event works.
     */
    public function testImportedScreenSavedBroadcast()
    {
        $this->expectsEvents([
            ImportedScreenSaved::class,
        ]);
        $screen = factory(Screen::class)->create();
        event(new ImportedScreenSaved($screen->id, $screen->toArray()));
    }

    /**
     * Asserts that the TestStatusEvent event works.
     */
    public function testTestStatusEventBroadcast()
    {
        $this->expectsEvents([
            TestStatusEvent::class,
        ]);
        event(new TestStatusEvent('test', 'test status event'));
    }

    /**
     * Asserts that the BuildScriptExecutor event works.
     */
    public function testScriptResponseEventBroadcast()
    {
        $this->expectsEvents([
            ScriptResponseEvent::class,
        ]);
        $user = factory(User::class)->create();
        event(new ScriptResponseEvent($user, 200, ['foo' => 'bar'], ['config_one' => 1], 'nonce001'));
    }
}
