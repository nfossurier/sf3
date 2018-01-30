<?php

namespace Tiquette\Domain;

use AppBundle\Forms\MemberSignUp;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class MemberFactory
{

    private $passwordEncoder;

    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createMember(MemberSignUp $memberSignUp): Member
    {
        $salt               = sha1(sha1(uniqid()));
        $rawEncodedPassword = $this->passwordEncoder->encodePassword(
            $memberSignUp->password,
            $salt
        );

        $member = Member::signUp(
            new Email($memberSignUp->email),
            $memberSignUp->nickname,
            new EncodedPassword($rawEncodedPassword, $salt)
        );

        return $member;
    }

}