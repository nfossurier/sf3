<?php

namespace AppBundle\Controller;

use AppBundle\Forms\PropositionTicketSubmission;
use AppBundle\Forms\TicketSubmission;
use AppBundle\Forms\Types\PropositionTicketSubmissionType;
use AppBundle\Forms\Types\TicketSubmissionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Tiquette\Domain\Ticket;

class SalesController extends Controller
{
    public function submitTicketAction(Request $request): Response
    {
        $ticketSubmission = new TicketSubmission();

        $ticketSubmissionForm = $this->createForm(TicketSubmissionType::class, $ticketSubmission);

        if ($request->isMethod('POST')) {
            $ticketSubmissionForm->handleRequest($request);
            if ($ticketSubmissionForm->isSubmitted() && $ticketSubmissionForm->isValid()) {

                $ticket = $this->get('ticket_factory')->fromTicketSubmission($ticketSubmission);
                $this->get('repositories.ticket')->save($ticket);

                return $this->redirectToRoute('ticket_submission_successful');
            }
        }

        return $this->render('@App/Sales/submit_ticket.html.twig',
            ['ticketSubmissionForm' => $ticketSubmissionForm->createView()]);
    }

    public function ticketSubmissionSuccessfulAction(Request $request): Response
    {
        return $this->render('@App/Sales/ticket_submission_successful.html.twig');
    }

    public function ticketAction(Request $request, string $ticketId): Response
    {
        $ticket = $this->get('repositories.ticket')->findOneById($ticketId);

        $propositionTicketSubmission = new PropositionTicketSubmission();

        $ticketPropositionForm = $this->createForm(PropositionTicketSubmissionType::class);

        $ticketPropositionForm->handleRequest($request);
        if ($ticketPropositionForm->isSubmitted() && $ticketPropositionForm->isValid()) {
            $ticketProposition = $this->get('ticket_proposition_factory')->fromTicketPropositionSubmission($ticketPropositionSubmission);
            $this->get('repositories.proposition')->save($ticketProposition);

            return $this->redirectToRoute('ticket_submission_successful');
        }

        return $this->render('@App/Sales/ticket.html.twig', [
            'ticket' => $ticket,
            'form'   => $ticketPropositionForm->createView()
        ]);
    }
}
