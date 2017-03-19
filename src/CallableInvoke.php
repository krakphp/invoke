<?php

namespace Krak\Invoke;

class CallableInvoke implements Invoke
{
    public function invoke($func, ...$params) {
        return call_user_func($func, ...$params);
    }
}
