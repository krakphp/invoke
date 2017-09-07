<?php

use Krak\Invoke;

describe('Krak Invoke', function() {
    describe('CallableInvoke', function() {
        it('will invoke a callable', function() {
            $invoke = new Invoke\CallableInvoke();
            assert($invoke->invoke('str_repeat', 'a', 2) == 'aa');
        });
    });
    describe('MethodInvoke', function() {
        it('will invoke a object method', function() {
            $invoke = Invoke\MethodInvoke::create('append');
            $array = new ArrayObject();
            $invoke->invoke($array, 1);
            $invoke->invoke($array, 2);
            assert(count($array) == 2);
        });
        it('will delegate if not forced', function() {
            $invoke = Invoke\MethodInvoke::create('append');
            $func = function($a) {
                assert($a);
            };
            $invoke->invoke($func, true);
        });
        it('can force the object method', function() {
            $invoke = Invoke\MethodInvoke::create('append', true);
            $func = function($a) {};
            try {
                $invoke->invoke($func, true);
                assert(false);
            } catch (\Exception $e) {
                assert(true);
            }
        });
    });
    describe('ContainerInvoke', function() {
        beforeEach(function() {
            $c = Krak\Cargo\liteContainer();
            $c['service'] = function() {
                return function() { return 1; };
            };
            $c['ArrayObject'] = function() {
                return new ArrayObject([1]);
            };
            $this->container = $c->toInterop();
        });
        it('will check if string is part of container', function() {
            $invoke = Invoke\ContainerInvoke::create($this->container);
            assert($invoke->invoke('service') === 1);
        });
        it('will invoke a service with method if a separator is given', function() {
            $invoke = Invoke\ContainerInvoke::createWithSeparator($this->container, '@');
            assert($invoke->invoke('ArrayObject@count') === 1);
        });
    });
});
