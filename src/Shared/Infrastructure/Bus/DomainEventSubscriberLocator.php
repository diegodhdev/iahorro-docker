<?php

declare(strict_types=1);

namespace Backend\Shared\Infrastructure\Bus;

use Traversable;

final class DomainEventSubscriberLocator
{
    private readonly array $mapping;

    public function __construct(Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function allSubscribedTo(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mapping);

        return $formatted[$eventClass];
    }


    public function all(): array
    {
        return $this->mapping;
    }
}
