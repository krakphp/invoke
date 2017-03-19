<?php

namespace Krak\Invoke;

interface Invoke {
    public function invoke($func, ...$params);
}
