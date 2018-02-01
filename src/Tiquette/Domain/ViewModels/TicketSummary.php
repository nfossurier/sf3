<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Tiquette\Domain\ViewModels;

class TicketSummary
{
    public $ticketId;
    public $eventName;
    public $eventDate;
    public $boughtAtPrice;
    public $sellerNickname;
    public $priceCurrency;
    public $numberOfOffersMade;
}
