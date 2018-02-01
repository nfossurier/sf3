<?php

namespace AppBundle\Utils;

use AppBundle\Forms\PropositionTicketSubmission;
use AppBundle\Forms\TicketSubmission;
use Tiquette\Domain\PropositionTicket;
use Tiquette\Domain\Ticket;
use Tiquette\Domain\UniqId;

class PropositionTicketFactory
{
    public function fromPropositionTicketSubmission(PropositionTicketSubmission $propositionTicketSubmission): PropositionTicket
    {
        return PropositionTicket::submit(

        );
//        return Ticket::submit(
//            $ticketSubmission->eventName,
//            \DateTimeImmutable::createFromMutable($ticketSubmission->eventDate),
//            $ticketSubmission->eventDescription,
//            0
//        );
    }
}
