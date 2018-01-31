<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Tiquette\Infrastructure\Repositories;

use Doctrine\DBAL\Connection;
use Tiquette\Domain\MemberNotFound;
use Tiquette\Domain\Ticket;
use Tiquette\Domain\TicketNotFound;
use Tiquette\Domain\TicketRepository;

class DbalTicketRepository implements TicketRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(Ticket $ticket): void
    {
        $data = [
            'uuid' => (string) $ticket->getId(),
            'event_name' => $ticket->getEventName(),
            'event_description' => $ticket->getEventDescription(),
            'event_date' => $ticket->getEventDate()->format('Y-m-d\TH:i:00'),
            'bought_at_price' => $ticket->getBoughtAtPrice(),
            'price_currency' => 'EUR',
        ];

        $this->connection->insert('tickets', $data);
    }

    public function findAll(): array
    {
        $query =<<<SQL
SELECT * FROM tickets;
SQL;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        $tickets = [];

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {

            $tickets[] = $this->hydrateFromRow($row);
        }

        return $tickets;
    }

    public function findOneById(string $ticketId)
    {
        $query =<<<SQL
SELECT * FROM tickets WHERE uuid = :ticketId LIMIT 1;
SQL;

        $statement = $this->connection->prepare($query);
        $statement->execute(['ticketId' => $ticketId]);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {

            throw TicketNotFound::unknownId($ticketId);
        }

        return $this->hydrateFromRow($row);
    }

    private function hydrateFromRow(array $row): Ticket
    {
        return Ticket::fromArray($row);
    }
}
