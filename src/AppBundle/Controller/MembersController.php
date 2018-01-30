<?php

namespace AppBundle\Controller;

use AppBundle\Forms\MemberSignUp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Tiquette\Domain\Email;
use Tiquette\Domain\EncodedPassword;
use Tiquette\Domain\Member;

class MembersController extends Controller
{
    public function signUpAction(Request $request): Response
    {
        $memberSignUp                       = new MemberSignUp();
        $memberSignUp->nickname             = $request->request->get('member_nickname');
        $memberSignUp->email                = $request->request->get('member_email');
        $memberSignUp->password             = $request->request->get('member_password');
        $memberSignUp->passwordConfirmation = $request->request->get('member_password_confirmation');

        if ($request->isMethod('POST')) {
            $violations = $this->get('validator')->validate($memberSignUp);
            if (\count($violations) > 0) {

                /** @var ConstraintViolation[] $violations */
                return $this->render('@App/Members/member_sign_up.html.twig', ['violations' => $violations]);
            }

            $this->get('repositories.member')->save($this->get('member.factory')->createMember($memberSignUp));

            return $this->redirectToRoute('member_sign_up_successful');
        }

        return $this->render('@App/Members/member_sign_up.html.twig', ['violations' => []]);
    }

    public function signUpSuccessfulAction(Request $request): Response
    {
        return new Response('Sign up successful');
    }
}
