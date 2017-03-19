<?php

namespace Krak\Invoke;

use Psr\Container\ContainerInterface;

class MethodInvoke extends InvokeDecorator
{
    private $method;
    private $force;

    public function __construct(Invoke $invoke, $method, $force = false) {
        parent::__construct($invoke);
        $this->method = $method;
        $this->force = $force;
    }

    public function invoke($func, ...$params) {
        if (is_object($func) && method_exists($func, $this->method)) {
            return $this->invoke->invoke([$func, $this->method], ...$params);
        } else if (!$this->force) {
            return $this->invoke->invoke($func, ...$params);
        }

        throw new \LogicException("Handler cannot be invoked because it does not contain the '$this->method' method");
    }

    public static function create($method, $force = false, Invoke $invoke = null) {
        return new self($invoke ?: new CallableInvoke(), $method, $force);
    }
}
