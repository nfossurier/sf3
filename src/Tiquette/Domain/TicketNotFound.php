<?php

namespace Tiquette\Domain;

use Tiquette\Exception;

class TicketNotFound extends \DomainException implements Exception
{
    public static function unknownId(int $ticketId): self
    {
        return new self(sprintf('Ticket with id "%s" not found.', $ticketId));
    }
}
