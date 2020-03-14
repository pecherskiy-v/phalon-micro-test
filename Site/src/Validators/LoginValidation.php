<?php

namespace App\Validators;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class LoginValidation extends Validation
{
    public function initialize()
    {
        $this->add(
            'login',
            new PresenceOf(
                [
                    'message' => 'The name is required',
                ]
            )
        );

        $this->add(
            'password',
            new PresenceOf(
                [
                    'message' => 'The password is required',
                ]
            )
        );

        $this->add(
            'password',
            new StringLength(
                [
                    'min' => 5,
                    'message' => 'pass not valid'
                ]
            )
        );

    }
}