<?php

namespace Krak\Invoke;

abstract class InvokeDecorator implements Invoke
{
    protected $invoke;

    public function __construct(Invoke $invoke) {
        $this->invoke = $invoke;
    }

    abstract public function invoke($func, ...$args);
}
