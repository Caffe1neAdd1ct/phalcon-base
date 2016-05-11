<?php

use \Phalcon\Db\Column;

class Users extends \Phalcon\Mvc\Model
{
    protected $id;
    protected $username;
    protected $password;
    protected $email;
    protected $token;
    protected $valid;
    protected $created;
    protected $deleted;
    
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getEmail() { return $this->email; }
    public function getToken() { return $this->token; }
    public function getValid() { return $this->valid; }
    public function getCreated() { return $this->created; }
    public function getDeleted() { return $this->deleted; }

    public function setId($id) { $this->id = (int) $id; }
    public function setUsername($username) { $this->username = (string) $username; }
    public function setPassword($password) { $this->password = (string) $password; }
    public function setEmail($email) { $this->email = (string) $email; }
    public function setToken($token) { $this->token = (string) $token; }
    public function setValid($valid) { $this->valid = (int) (bool) $valid; }
    public function setCreated($created) { $this->created = (string) $created; }
    public function setDeleted($deleted) { $this->deleted = (string) $deleted; }

    /**
     * Find one user record by their username
     * @param string $username
     * @return Users
     */
    public static function findByUsernameFirst($username)
    {
        $parameters = array('username' => (string) $username);
        $types = array('username' => Column::BIND_PARAM_STR);

        $userRecord = self::findFirst(array(
            "username = :username:",
            "bind" => $parameters,
            "bindTypes" => $types
        ));
        
        return $userRecord;
    }
    
    /**
     * Find a user record with a matching username and email
     * @param string $username
     * @param string $email
     * @return Users
     */
    public static function findByUsernameAndEmail($username, $email)
    {
        $parameters = array(
            'username' => (string) $username, 
            'email' => (string) $email
        );
        $types = array(
            'username' => Column::BIND_PARAM_STR, 
            'email' => Column::BIND_PARAM_STR
        );

        $userRecord = self::findFirst(array(
            "username = :username: AND email = :email:",
            "bind" => $parameters,
            "bindTypes" => $types
        ));
        
        return $userRecord;
    }
    
    /**
     * 
     * @param string $token
     * @return Users
     */
    public static function findByTokenFirst($token)
    {
        $parameters = array('token' => (string) $token);
        $types = array('token' => Column::BIND_PARAM_STR);
        
        $userRecord = self::findFirst(array(
            "token = :token:",
            "bind" => $parameters,
            "bindTypes" => $types
        ));
        
        return $userRecord;
    }
    
    public function initialize()
    {
        /** only changed values are saved */
        $this->useDynamicUpdate(true);
    }

    
    /**
     * Check username is unique
     * @return boolean
     */
    public function validation()
    {
        $this->validate(new \Phalcon\Mvc\Model\Validator\Uniqueness(array('field' => 'username', 'message' => 'Username is unavailable, please try another name.')));
        $this->validate(new \Phalcon\Mvc\Model\Validator\Uniqueness(array('field' => 'email', 'message' => 'Email address already registered, please try a password reset.')));
        
        $this->validate(new \Phalcon\Mvc\Model\Validator\Email(array('field' => 'email', 'required' => true,)));
        $this->validate( new \Phalcon\Mvc\Model\Validator\PresenceOf(array('field' => 'username', 'required' => true)));
        
        return ($this->validationHasFailed() != true);
    }
    
    /**
     * Creates hash
     * Created encrypted password
     * Sets initial date values
     */
    public function beforeValidationOnCreate()
    {
        /* @var $security Phalcon\Security */
        $security = $this->getDI()->getSecurity();
        
        $this->setPassword($security->hash($this->password));
        $this->setToken($security->getToken());
        $this->setValid(0);
        $this->setCreated(date('Y-m-d H:i:s'));
        $this->setDeleted('0000-00-00 00:00:00');
    }
    
    public function afterCreate()
    {
        /* @var $mail Mail\Mail */
        $mail = $this->getDI()->getMail();
        
        $mail->send(
            array($this->getEmail() => $this->getUsername()), 
            "Verify your account.", 
            'verify', 
            array(
                'verifyUrl' => 'signup/verify',
                'token' => $this->getToken()
            )
        );
        
    }

}
