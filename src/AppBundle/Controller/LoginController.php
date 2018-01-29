<?php

namespace AppBundle\Controller;

use AppBundle\Forms\MemeberRegistration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;

class LoginController extends Controller
{
    public function loginAction(Request $request): Response
    {
        return $this->render('@App/login.html.twig', []);
    }

    public function signUpAction(Request $request): Response
    {
        $memberRegistration = new MemeberRegistration();
        $memberRegistration->username = $request->request->get('username');
        $memberRegistration->rawPassword = $request->request->get('raw_password');

        if ($request->isMethod('POST')) {
            $violations = $this->get('validator')->validate($memberRegistration);
            if (\count($violations) > 0) {

                /** @var ConstraintViolation[] $violations */
                return $this->render('@App/signup.html.twig', ['violations' => $violations]);
            }

//            $ticket = Ticket::submit(
//                $ticketSubmission->eventName,
//                \DateTimeImmutable::createFromFormat('Y-m-d\TH:m', $ticketSubmission->eventDate),
//                $ticketSubmission->eventDescription,
//                0
//            );

//            $this->get('repositories.ticket')->save($ticket);

//            return $this->redirectToRoute('ticket_submission_successful');
        }


        return $this->render('@App/signup.html.twig');
    }
}
