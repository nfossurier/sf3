<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Utils;

use AppBundle\Forms\TicketSubmission;
use Tiquette\Domain\Ticket;
use Tiquette\Domain\UniqId;

class TicketFactory
{
    public function fromTicketSubmission(TicketSubmission $ticketSubmission): Ticket
    {
        return Ticket::submit(
            $ticketSubmission->eventName,
            \DateTimeImmutable::createFromMutable($ticketSubmission->eventDate),
            $ticketSubmission->eventDescription,
            0
        );
    }
}
