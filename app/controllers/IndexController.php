<?php

class IndexController extends ControllerBase
{
    
    public function initialize()
    {
        parent::initialize();
        
        $this->loggedInRedirect();
    }

    public function indexAction()
    {
        $form = new LoginForm();

        if($this->request->isPost() && $form->isValid($this->request->getPost())) {
            
            /* @var $user Users */
            $user = Users::findByUsernameFirst($this->request->getPost('username'));

            if($user && $this->security->checkHash($this->request->getPost('password'), $user->getPassword())) {
                
                $this->session->set('auth', array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'valid' => $user->getValid(),
                    'created' => $user->getCreated(),
                    'deleted' => $user->getDeleted()
                ));
                
                return $this->response->redirect('overview');

            } else {
                $this->view->form = $form;
                return $this->flash->error((string) "Incorrect credentials, please try again or use the reset link.");
            }
            
        } else {
            $this->view->form = $form;
        } 
    }
    
    public function logoutAction()
    {
        
        $this->session->destroy();
        $this->response->redirect('index');
        
    }
    
    public function forgottenAction()
    {
        $form = new ForgottenForm();
        
        if($this->request->isPost() && $form->isValid($this->request->getPost())) {
            
            $resetToken = $this->getDI()->getSecurity()->getToken();
            $user = Users::findByUsernameAndEmail($this->request->getPost('username'), $this->request->getPost('email'));
            
            if($user) {
                $user->setToken($resetToken);
            }
                
            if($user && $user->update()) {

                /* @var $mail Mail\Mail */
                $mail = $this->getDI()->getMail();

                $mail->send(
                    array($user->getEmail() => $user->getUsername()), 
                    "Password reset link enclosed.", 
                    'forgotten', 
                    array(
                        'verifyUrl' => 'index/reset',
                        'token' => $resetToken
                    )
                );
                
            } else {
                $this->flash->error('Failed to set a reset token on your account, please contact support.');
            }

            $this->flash->notice('If you entered your username and email address correctly, further instructions will be sent to your email address.');
            return $this->response->redirect('index/index');

        } else {
            $this->view->form = $form;
        }
    }
    
    public function resetAction()
    {
        $form = new ResetForm();
        $form->get('token')->setDefault($this->request->get('token'));
        
        if($this->request->isPost() && $form->isValid($this->request->getPost())) {
            
            $user = Users::findByTokenFirst($this->request->getPost('token'));
            
            if($user) {
                /* @var $security \Phalcon\Security */
                $security = $this->getDI()->getSecurity();
                $user->setPassword($security->hash($this->request->get('password')));
            }
            
            if($user && $user->update()) {
                $this->flash->success('Password successfully reset, please login with your new password.');
            } else {
                $this->flash->error('Failed to reset your password, please contact our support team.');
            }
            
            return $this->response->redirect('index/index');
        }
        
        $this->view->form = $form;
    }

}