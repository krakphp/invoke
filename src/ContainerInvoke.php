<?php

namespace Krak\Invoke;

use Psr\Container\ContainerInterface;

class ContainerInvoke extends InvokeDecorator
{
    private $container;

    public function __construct(Invoke $invoke, ContainerInterface $container) {
        parent::__construct($invoke);
        $this->container = $container;
    }

    public function invoke($func, ...$params) {
        if (is_string($func) && $this->container->has($func)) {
            $func = $this->container->get($func);
        }

        return $this->invoke->invoke($func, ...$params);
    }

    public static function create(ContainerInterface $container, Invoke $invoke = null) {
        return new self($invoke ?: new CallableInvoke(), $container);
    }
}
