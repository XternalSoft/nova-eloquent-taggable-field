<?php

namespace XternalSoft\NovaEloquentTaggableField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tags extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-eloquent-taggable-field';

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->multiple();
    }

    public function multiple(bool $multiple = true)
    {
        $this->withMeta(
            [
                'multiple'        => $multiple,
                'suggestionLimit' => 5,
            ]
        );

        if (! $this->meta['multiple']) {
            $this->doNotLimitSuggestions();
        }

        return $this;
    }

    public function single(bool $single = true)
    {
        $this->withMeta(['multiple' => ! $single]);

        if (! $this->meta['multiple']) {
            $this->doNotLimitSuggestions();
        }

        return $this;
    }

    public function withoutSuggestions()
    {
        return $this->limitSuggestions(0);
    }

    public function limitSuggestions(int $maxNumberOfSuggestions)
    {
        return $this->withMeta(['suggestionLimit'=> $maxNumberOfSuggestions]);
    }

    public function doNotLimitSuggestions()
    {
        return $this->limitSuggestions(9999);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $requestValue = $request[$requestAttribute];
        $tagNames = explode('-----', $requestValue);
        $tagNames = array_filter($tagNames);

        $class = get_class($model);

        $class::saved(
            static function ($model) use ($tagNames) {
                $model->retag($tagNames);
            }
        );
    }

    public function resolveAttribute($resource, $attribute = null)
    {
        return $resource->tagArray;
    }
}
