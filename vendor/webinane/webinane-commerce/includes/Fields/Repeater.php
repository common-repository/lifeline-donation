<?php

namespace WebinaneCommerce\Fields;

use WebinaneCommerce\Fields\Field;

class Repeater extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'repeater';

    /**
     * The field's suggestions callback.
     *
     * @var array|callable
     */
    private $fields;

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
    public function resolveValues($data)
    {
        if (is_callable($this->values)) {
            return call_user_func($this->values, $data) ?? null;
        }

        return $this->values;
    }

    /**
     * Display the field as raw HTML using Vue.
     *
     * @return $this
     */
    public function fields(Array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'props' => ['fields' => $this->fields],
        ]);
    }
}
