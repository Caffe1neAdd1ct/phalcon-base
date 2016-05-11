<?php

namespace Mail;

use Swift_Message as Message;
use Swift_SmtpTransport as Smtp;

/**
 * Sends e-mails based on pre-defined templates
 */
class Mail extends \Phalcon\Mvc\User\Component
{
    protected $transport;

    /**
     * Retrieve volt templates rendered into html passing any required parameters
     * @param string $name
     * @param array $params
     * @return string/html
     */
    public function getTemplate($name, $params)
    {
        $parameters = array_merge(array(
            'publicUrl' => $this->getDI()->getApp()->url->host . $this->getDI()->getApp()->url->baseUri
        ), $params);
        
        $app = $this->getDI()->getApp();
        
        $this->getDI()->set('simpleView', function() use ($app) {
            $view = new \Phalcon\Mvc\View\Simple();
            $view->setViewsDir(APP_DIR . $app->application->viewsDir);
            $view->registerEngines(array(
                ".volt" => function ($view, $di) {
                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                    $volt->setOptions(array(
                        'compiledPath'      => APP_DIR . '/cache/volt/',
                        'compiledSeparator' => '_',
                        'compiledExtension' => '.compiled'
                    ));
                    $compiler = $volt->getCompiler();
                    $compiler->addFunction('is_a', 'is_a');
                    return $volt;
                }
            ));
            return $view;
        });



        /* @var $simpleView \Phalcon\Mvc\View\Simple */
        $simpleView = $this->getDI()->get('simpleView');
        
        foreach ($parameters as $key => $value) {
            $simpleView->{$key} = $value;
        }
        
        $html = $simpleView->render('emails/' . $name, $parameters);
        
        return $html;
    }
    
    /**
     * Sends e-mails based on volt templates
     * @param array $to Email address or addresses to send to
     * @param string $subject
     * @param string $name
     * @param array $params
     */
    public function send($to, $subject, $name, $params)
    {
        $template     = $this->getTemplate($name, $params);
        // Create the message
        $message      = Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom(array(
                $this->getDI()->getApp()->mail->from => $this->getDI()->getApp()->mail->name
            ))
            ->setBody($template, 'text/html');

        if (!$this->transport) {
            $this->transport = Smtp::newInstance(
                $this->getDI()->getApp()->mail->server, 
                $this->getDI()->getApp()->mail->port, 
                $this->getDI()->getApp()->mail->security
            )
            ->setUsername($this->getDI()->getApp()->mail->username)
            ->setPassword($this->getDI()->getApp()->mail->password);
        }
        // Create the Mailer using your created Transport
        $mailer = \Swift_Mailer::newInstance($this->transport);
        return $mailer->send($message);
    }

}
