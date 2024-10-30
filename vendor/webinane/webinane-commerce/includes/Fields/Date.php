<?php

namespace WebinaneCommerce\Fields;

use WebinaneCommerce\Fields\Field;

class Date extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'el-date-picker';

    /**
     * The field's suggestions callback.
     *
     * @var array|callable
     */
    public $suggestions;

    /**
     * Set the callback or array to be used to determine the field's suggestions list.
     *
     * @param  array|callable  $suggestions
     * @return $this
     */
    public function suggestions($suggestions)
    {
        $this->suggestions = $suggestions;

        return $this;
    }

    /**
     * Resolve the display suggestions for the field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function resolveSuggestions($request)
    {
        if (is_callable($this->suggestions)) {
            return call_user_func($this->suggestions, $request) ?? null;
        }

        return $this->suggestions;
    }

    /**
     * Display the field as raw HTML using Vue.
     *
     * @return $this
     */
    public function format($format)
    {
        return $this->withMeta(['format' => $format]);
    }
    /**
     * Display the field as raw HTML using Vue.
     *
     * @return $this
     */
    public function valueFormat($format)
    {
        return $this->withMeta(['value-format' => $format]);
    }
    /**
     * Display the field as raw HTML using Vue.
     * types year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
     *
     * @return $this
     */
    public function type($type = 'date')
    {
        return $this->withMeta(['type' => $type]);
    }
    

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'suggestions' => $this->resolveSuggestions(''),
        ]);
    }
}
