<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Store;

use Backend\Leads\Domain\LeadEmail;
use Backend\Leads\Domain\LeadId;
use Backend\Leads\Domain\LeadName;
use Backend\Leads\Domain\LeadPhone;
use Backend\Shared\Domain\Bus\CommandHandler;

final class StoreLeadCommandHandler implements CommandHandler
{
    public function __construct(private readonly LeadStorer $storer) {}

    public function __invoke(StoreLeadCommand $command)
    {
        $id = new LeadId($command->id());
        $name = new LeadName($command->name());
        $email = new LeadEmail($command->email());
        $phone = new LeadPhone($command->phone());

        $this->storer->__invoke($id, $name, $email, $phone);
    }
}
