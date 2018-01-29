<?php

namespace AppBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;

class MemeberRegistration
{
    /** @Assert\NotBlank */
    public $username;

    /** @Assert\NotBlank */
    public $rawPassword;

}
