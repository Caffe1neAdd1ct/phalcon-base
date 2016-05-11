<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use zVPS\PhalconValidation\AlphaNumericValidator;

class LoginForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $username = new Text('username', array(
            'class' => 'form-control'
        ));
        $username->setLabel('Username');
        $username->addValidators(array(
            new PresenceOf(array(
                'message' => 'Please enter your username.',
            )),
            new AlphaNumericValidator(array(
                'message' => 'Only Alpha, Numeric and Space characters please.', 
                'allowWhiteSpace' => true,
            )),
            new StringLength(array(
                'max' => 100,
                'messageMaximum' => 'Username is too long. Maximum 100 characters.',
            )),
        ));
        $this->add($username);

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
        ));
        $this->add($password);
        
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));
        $this->add($csrf);
        
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));
        $csrf->clear();
        $this->add($csrf);
        
        
        
        
        // Sign Up
        $this->add(new Submit('Login', array(
            'class' => 'btn btn-primary'
        )));
    }
}
