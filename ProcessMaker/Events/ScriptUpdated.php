<?php

namespace ProcessMaker\Events;

use Illuminate\Foundation\Events\Dispatchable;
use ProcessMaker\Contracts\SecurityLogEventInterface;
use ProcessMaker\Helpers\ArrayHelper;
use ProcessMaker\Models\Script;
use ProcessMaker\Traits\FormatSecurityLogChanges;

class ScriptUpdated implements SecurityLogEventInterface
{
    use Dispatchable;
    use FormatSecurityLogChanges;

    private array $changes;

    private array $original;

    private Script $script;

    /**
     * Create a new event instance.
     *
     * @param Script $script
     * @param array $changes
     * @param array $original
     */
    public function __construct(Script $script, array $changes, array $original)
    {
        $this->script = $script;
        $this->changes = $changes;
        $this->original = $original;

        if (isset($original['script_category_id']) && isset($changes['script_category_id'])) {
            $this->changes['script_category'] = ArrayHelper::getNamesByIds('scriptCategory', $this->changes['script_category_id'], 'name');
            $this->original['script_category'] = ArrayHelper::getNamesByIds('scriptCategory', $this->original['script_category_id'], 'name');
            unset($this->changes['script_category_id']);
            unset($this->original['script_category_id']);
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
            'script_id' => $this->script->id
        ];
    }

    /**
     * Get specific data related to the event
     *
     * @return array
     */
    public function getData(): array
    {
        $changes = $this->changes;
        $original = $this->original;
        $basic = isset($changes['code']) ? [
            'script_name' => $this->script->getAttribute('title'),
            'last_modified' => $this->script->getAttribute('updated_at'),
        ] : [
            'script_name' => $this->script->getAttribute('title'),
            'last_modified' => $this->script->getAttribute('updated_at'),
        ];
        unset($changes['code']);
        unset($original['code']);

        return array_merge($basic, $this->formatChanges($changes, $original));
    }

    public function getEventName(): string
    {
        return 'ScriptUpdated';
    }
}
