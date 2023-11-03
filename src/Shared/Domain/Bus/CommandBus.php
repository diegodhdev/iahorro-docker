<?php

declare(strict_types=1);

namespace Backend\Shared\Domain\Bus;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
