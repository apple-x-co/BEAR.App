<?php

declare(strict_types=1);

namespace MyVendor\MyProject;

use BEAR\Package\Injector as PackageInjector;
use Ray\Di\InjectorInterface;

final class Injector
{
    private function __construct()
    {
    }

    public static function getInstance(string $context) : InjectorInterface
    {
        return PackageInjector::getInstance(__NAMESPACE__, $context, dirname(__DIR__));
    }
}
