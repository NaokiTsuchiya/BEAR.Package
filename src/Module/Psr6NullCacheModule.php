<?php

declare(strict_types=1);

namespace BEAR\Package\Module;

use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\Shared;
use Symfony\Component\Cache\Adapter\NullAdapter;

final class Psr6NullCacheModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Local::class)->to(NullAdapter::class)->in(Scope::SINGLETON);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->to(NullAdapter::class)->in(Scope::SINGLETON);
    }
}
