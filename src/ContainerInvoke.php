<?php

namespace Krak\Invoke;

use Psr\Container\ContainerInterface;

class ContainerInvoke extends InvokeDecorator
{
    private $container;
    private $separator;

    public function __construct(Invoke $invoke, ContainerInterface $container, $separator = null) {
        parent::__construct($invoke);
        $this->container = $container;
        $this->separator = $separator;
    }

    public function invoke($func, ...$params) {
        if (is_string($func)) {
            if ($this->container->has($func)) {
                $func = $this->container->get($func);
            } else if ($this->separator && strpos($func, $this->separator) !== false) {
                list($service_id, $method) = explode($this->separator, $func);
                $func = [$this->container->get($service_id), $method];
            }
        }

        return $this->invoke->invoke($func, ...$params);
    }

    public static function create(ContainerInterface $container, Invoke $invoke = null) {
        return new self($invoke ?: new CallableInvoke(), $container);
    }

    public static function createWithSeparator(ContainerInterface $container, $separator, Invoke $invoke = null) {
        return new self($invoke ?: new CallableInvoke(), $container, $separator);
    }
}
