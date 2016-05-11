<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 * @todo replace hardcoded arrays with permissions, roles, resources models (db driven)
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin {

    /**
     * Returns an existing or new access control list
     * @returns AclList
     */
    public function getAcl()
    {
        if (!isset($this->persistent->acl)) {
            $acl = new AclList();
            $acl->setDefaultAction(Acl::DENY);
            //Register roles
            
            $roles = array(
                'admins' => new Role('Admins'),
                'users'  => new Role('Users'),
                'guests' => new Role('Guests'),
            );
            
            foreach ($roles as $role) {
                $acl->addRole($role);
            }
            
            /**
             * @todo implement admin only area
             */
            $adminResources = array(
//                'admins' => array('users'),
            );
            
            //Private area resources
            $privateResources = array(
                'overview' => array('index'),
                'users' => array('index', 'delete', 'save', 'create', 'edit', 'new', 'search'),
                'signup' => array('verify'),
            );
            
            foreach ($privateResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }
            
            //Public area resources
            $publicResources = array(
                'index' => array('index'),
                'errors' => array('show404', 'show401', 'show500'),
                'signup' => array('index', 'verify'),
            );
            
            foreach ($publicResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }
            
            //Grant access to public areas to both users and guests, admins won't have access to the game
            foreach ($roles as $role) {
                foreach ($publicResources as $resource => $actions) {
                    $acl->allow($role->getName(), $resource, '*');
                }
            }
            
            //Grant acess to private area to role Users
            foreach ($privateResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Users', $resource, $action);
                }
            }
            
            //Grant access to admin area to role Admins
            foreach ($adminResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Admins', $resource, $action);
                }
            }
            
            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }
        
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        
        $acl = $this->getAcl();
        $allowed = $acl->isAllowed($role, $controller, $action);
        if ($allowed != Acl::ALLOW && !$auth) {
            $dispatcher->forward(array(
                'controller' => 'errors',
                'action' => 'show401'
            ));
            return false;
        } elseif ($allowed != Acl::ALLOW && $auth) {
            $dispatcher->forward(array(
                'controller' => 'errors',
                'action' => 'show403'
            ));
            return false;
        }
    }

}
