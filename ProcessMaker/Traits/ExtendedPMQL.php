<?php

namespace ProcessMaker\Traits;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use ProcessMaker\Query\Expression;
use ProcessMaker\Query\Traits\PMQL;
use Illuminate\Database\Eloquent\Builder;
use ProcessMaker\Query\IntervalExpression;
use Throwable;

trait ExtendedPMQL
{
    use PMQL {
        PMQL::scopePMQL as parentScopePMQL;
    }

    /**
     * PMQL scope that extends the standard PMQL scope by supporting any custom
     * aliases specified in the model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $query
     * @param callable $callback
     *
     * @return mixed
     */
    public function scopePMQL(Builder $builder, string $query, callable $callback = null)
    {
        if (! $callback) {
            // If a callback isn't passed to the scope, we handle it here
            return $this->parentScopePMQL($builder, $query, function($expression) use ($builder) {
                return $this->handle($expression, $builder);
            });
        } else {
            // If a callback is passed to the scope, we skip handling it here
            return $this->parentScopePMQL($builder, $query, $callback);
        }
    }

    /**
     * Callback function to check for and handle any field aliases, value
     * aliases, or field wildcards specified in the given model.
     *
     * @param \ProcessMaker\Query\Expression $expression
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return mixed
     */
    private function handle(Expression $expression, Builder $builder)
    {
        // Setup our needed variables
        $field = $expression->field->field();
        $model = $builder->getModel();

        if (is_string($field)) {
            // Parse our value
            $value = $this->parseValue($expression);

            // PMQL Interval expressions do not have values
            if (method_exists($expression->value, 'setValue')) {
                $expression->value->setValue($value);
            }

            // Title case our field name so we can suffix it to our method names
            $fieldMethodName = ucfirst(strtolower($field));

            // A field alias specifies that a field name used in a PMQL query
            // translates to a different field name in our database.
            $method = "fieldAlias{$fieldMethodName}";
            if (method_exists($model, $method)) {
                return $expression->field->setField($model->{$method}());
            }

            // A value alias specifies that a value must be parsed by a callback
            // function if its field name matches a specific word.
            $method = "valueAlias{$fieldMethodName}";
            if (method_exists($model, $method)) {
                return $model->{$method}($value, $expression, $builder);
            }

            // A field wildcard passes any fields not caught by a field or value
            // alias to a callback function for any needed processing. If the
            // callback returns void, the PMQL is parsed as if there is
            // no callback.
            $method = "fieldWildcard";
            if (method_exists($model, $method)) {
                return $model->{$method}($value, $expression, $builder);
            }
        }
    }

    /**
     * Set the value as a string if possible. Also convert to the logged-in
     * user's timezone if the value is parsable by Carbon as a date.
     *
     * @param \ProcessMaker\Query\Expression $expression
     *
     * @return mixed
     */
    private function parseValue($expression)
    {
        // Check the type of our value; set as string if possible
        if (is_a($expression->value, 'ProcessMaker\\Query\\LiteralValue')) {
            $value = $expression->value->value();
        } else {
            $value = $expression->value;
        }

        // Check to see if the value is parsable as a date
        if ((is_string($value) && strlen($value) > 1)) {
            switch ($value) {
                case $value instanceof IntervalExpression: 
                    $value = $this->parseDate($value);
                    break;
                default: 
                    // Check to see if the value is a date/datetime formatted if not return original value
                    $isDateFormatted = Carbon::hasFormatWithModifiers($value, 'Y#m#d');
                    $isDateTimeFormatted = Carbon::hasFormatWithModifiers($value, 'Y#m#d h:i:s');
                    if ($isDateFormatted || $isDateTimeFormatted) {
                        $value = $this->parseDate($value);
                    }
                    break;
            }
        }

        return $value;
    }

    private function parseDate($value) {
        $parsed = Carbon::parse($value, auth()->user()->timezone);
        $parsed->setTimezone(config('app.timezone'));
        return $parsed->toDateTimeString();
    }
}
