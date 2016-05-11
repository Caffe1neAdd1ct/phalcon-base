<?php

class SignupController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('Signup');
        parent::initialize();
    }

    public function indexAction()
    {
        if ($this->session->has('auth')) {
            $this->view->disable();
            $this->response->redirect('overview/index');
        }

        $form = new SignupForm();

        if ($this->request->isPost() && $form->isValid($this->request->getPost())) {

            $user = new Users();

            $user->assign(array(
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ));

            if ($user->create()) {

                /** @todo login user and redirect to overview controller */
                $this->session->set('auth', array(
                    'id'       => $user->getId(),
                    'username' => $user->getUsername(),
                    'email'    => $user->getEmail(),
                    'valid'    => $user->getValid(),
                    'created'  => $user->getCreated(),
                    'deleted'  => $user->getDeleted(),
                ));

                return $this->response->redirect('overview/index');
            }

            foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message->getMessage());
            }
        }

        $this->view->form = $form;
    }

    public function verifyAction()
    {
        $token = $this->request->get('token');
        
        $user = Users::findByTokenFirst($token);
        
        if($user && $user->getToken() === $token) {
            
            $user->setValid(1);
            $user->setToken(0);
            
            if($user->update()) {
                /* @var $mail Mail\Mail */
                $mail = $this->getDI()->getMail();

                $mail->send(
                    array($user->getEmail() => $user->getUsername()), 
                    "Account successfully verified.", 
                    'verified', 
                    array()
                );
                
                $this->flash->success('Account validation succeeded, thankyou for verifying your account.');
            } else {
                $this->flash->error(
                    'Verification token was successful, however we failed to update your account to verified. Please contact our support team to fix this.'
                );
                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message->getMessage());
                }
            }

            return $this->response->redirect('index/index');
            
        } else {
            return $this->response->redirect('index/index');
        }
    }

}
