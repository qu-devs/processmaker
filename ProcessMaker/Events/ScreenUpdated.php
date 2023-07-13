<?php

namespace ProcessMaker\Events;

use Illuminate\Foundation\Events\Dispatchable;
use ProcessMaker\Contracts\SecurityLogEventInterface;
use ProcessMaker\Models\Screen;
use ProcessMaker\Models\ScreenCategory;
use ProcessMaker\Traits\FormatSecurityLogChanges;

class ScreenUpdated implements SecurityLogEventInterface
{
    use Dispatchable;
    use FormatSecurityLogChanges;

    private Screen $screen;

    private array $changes;

    private array $original;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Screen $screen, array $changes, array $original)
    {
        $this->screen = $screen;
        $this->changes = $changes;
        $this->original = $original;

        // Get category name
        $this->original['Screen Categories'] = isset($original['screen_category_id'])
        ? ScreenCategory::getNamesByIds($this->original['screen_category_id']) : '';
        unset($this->original['screen_category_id']);
        $this->changes['Screen Categories'] = isset($changes['screen_category_id'])
        ? ScreenCategory::getNamesByIds($this->changes['screen_category_id']) : '';
        unset($this->changes['screen_category_id']);
    }

    /**
     * Get specific data related to the event
     *
     * @return array
     */
    public function getData(): array
    {
        $basic = [
            'name' => [
                'label' => $this->screen->getAttribute('title'),
                'link' => route('screen-builder.edit', ['screen' => $this->screen->getAttribute('id')]),
            ],
            'last_modified' => $this->screen->getAttribute('updated_at'),
        ];
        if (array_key_exists('config', $this->changes)) {
            return $basic;
        } else {
            return array_merge($basic, $this->formatChanges($this->changes, $this->original));
        }
    }

    /**
     * Get specific changes without format related to the event
     *
     * @return array
     */
    public function getChanges(): array
    {
        return [
            'id' => $this->screen->getAttribute('id'),
            'name' => $this->screen->getAttribute('title'),
        ];
    }

    /**
     * Get the Event name with the syntax ‘[Past-test Action] [Object]’
     *
     * @return string
     */
    public function getEventName(): string
    {
        return 'ScreenUpdated';
    }
}
