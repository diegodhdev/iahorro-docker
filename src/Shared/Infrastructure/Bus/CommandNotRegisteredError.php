<?php

declare(strict_types=1);

namespace Backend\Shared\Infrastructure\Bus;

use Backend\Shared\Domain\Bus\Command;
use RuntimeException;

final class CommandNotRegisteredError extends RuntimeException
{
    public function __construct(Command $command)
    {
        $commandClass = $command::class;

        parent::__construct("The command <$commandClass> hasn't a command handler associated");
    }
}
