<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Destroy;

use Backend\Leads\Domain\LeadId;
use Backend\Shared\Domain\Bus\CommandHandler;

final class DestroyLeadCommandHandler implements CommandHandler
{
    public function __construct(private readonly LeadDestroyer $destroyer) {}

    public function __invoke(DestroyLeadCommand $command)
    {
        $id = new LeadId($command->id());

        $this->destroyer->__invoke($id);
    }
}
