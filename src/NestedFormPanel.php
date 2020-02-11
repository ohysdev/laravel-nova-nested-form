<?php

namespace Yassi\NestedForm;

use Laravel\Nova\Panel;

class NestedFormPanel extends Panel
{
    /**
     * Nested form.
     * 
     * @var NestedForm
     */
    protected $nestedForm;

    /**
     * Constructor.
     */
    public function __construct(NestedForm $nestedForm)
    {
        $this->nestedForm = $nestedForm;

        $this->nestedForm->asPanel($this);

        parent::__construct(__('Create Related :resource', ['resource' => __($this->nestedForm->name)]), [$this->nestedForm]);
    }

    /**
     * Getter.
     */
    public function __get($key)
    {
        return key_exists($key, $this) ? parent::__get($key) : $this->nestedForm->$key;
    }

    /**
     * Setter.
     */
    public function __set($key, $value)
    {
        key_exists($key, $this) ? parent::__set($key, $value) : $this->nestedForm->$key = $value;
    }

    /**
     * Caller.
     */
    public function __call($method, $arguments)
    {
        return method_exists($this, $method) ? parent::__call($method, $arguments) : call_user_func([$this->nestedForm, $method], ...$arguments);
    }
}
