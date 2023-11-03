<?php

declare(strict_types=1);

namespace Backend\Leads\Application\Store;

use Backend\Shared\Domain\Bus\Command;

final class StoreLeadCommand implements Command
{
    public function __construct(string $id, private readonly string $name, private readonly string $email, private readonly ?string $phone)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function phone(): ?string
    {
        return $this->phone;
    }
}
