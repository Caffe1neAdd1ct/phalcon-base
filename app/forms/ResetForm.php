<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class ResetForm extends Form
{
    public function initialize($entity = null, $options = null)
    {        
        $password = new Password('password', array(
            'class' => 'form-control'
        ));
        $password->setLabel('Password');
        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'The password is required'
            )),
            new StringLength(array(
                'min' => 6,
                'max' => 100,
                'messageMinimum' => 'Password is too short. Minimum 6 characters',
                'messageMaximum' => 'Password is too long. Maximum 100 characters.'
            )),
            new Confirmation(array(
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ))
        ));
        $this->add($password);
        
        
        $confirmPassword = new Password('confirmPassword', array(
            'class' => 'form-control'
        ));
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'The confirmation password is required'
            )),
            new StringLength(array(
                'min' => 6,
                'max' => 100,
                'messageMinimum' => 'Confirm password is too short. Minimum 6 characters.',
                'messageMaximum' => 'Confirm password is too long. Maximum 100 characters.'
            )),
        ));
        $this->add($confirmPassword);
        
        $token = new Hidden('token');
        $token->addValidator(
            new PresenceOf(
                array(
                    'message' => 'The reset token must be passed to this process via the reset link in an email sent to you.'
                )
            )
        );
        $this->add($token);
        
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));
        $csrf->clear();
        $this->add($csrf);
        
        // Sign Up
        $this->add(new Submit('Reset', array(
            'class' => 'btn btn-primary'
        )));
    }
}