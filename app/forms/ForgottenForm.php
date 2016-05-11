<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use zVPS\PhalconValidation\AlphaNumericValidator;

class ForgottenForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $username = new Text('username', array(
            'class' => 'form-control'
        ));
        $username->setLabel('Username');
        $username->addValidators(array(
            new PresenceOf(array(
                'message' => 'Username is needed.',
            )),
            new AlphaNumericValidator(array(
                'message' => 'Only Alpha, Numeric and Space characters can be used for your account username.', 
                'allowWhiteSpace' => true,
            )),
            new StringLength(array(
                'max' => 100,
                'messageMaximum' => 'Username is too long. Maximum 100 characters.',
            )),
        ));
        $this->add($username);
        
        $email = new Text('email', array(
            'class' => 'form-control'
        ));
        $email->setLabel('E-Mail');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required',
            )),
            new Email(array(
                'message' => 'The e-mail is not valid',
            )),
            new StringLength(array(
                'max' => 100,
                'messageMaximum' => 'E-Mail is too long. Maximum 100 characters.',
            )),
        ));
        $this->add($email);
        
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));
        $csrf->clear();
        $this->add($csrf);
        
        
        // Sign Up
        $this->add(new Submit('Request', array(
            'class' => 'btn btn-primary'
        )));
    }
}