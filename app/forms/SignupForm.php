<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use zVPS\PhalconValidation\AlphaNumericValidator;

class SignupForm extends Form
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
                'max' => 20,
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
        

        $terms = new Check('terms', array(
            'value' => 'yes',
        ));
        $terms->setLabel('Accept terms and conditions');
        $terms->addValidator(new Identical(array(
            'value' => 'yes',
            'message' => 'Terms and conditions must be accepted.'
        )));
        $this->add($terms);
        
        
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));
        $csrf->clear();
        $this->add($csrf);
        
        
        // Sign Up
        $this->add(new Submit('Sign Up', array(
            'class' => 'btn btn-success'
        )));
    }
}