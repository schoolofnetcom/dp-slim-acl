<?php

namespace App;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl
{
    private $acl;

    public function __construct()
    {
        $this->acl = new ZendAcl;
    }

    public function createRoles()
    {
        $this->acl->addRole(new Role('guest'));
        $this->acl->addRole(new Role('member'), ['guest']);
        $this->acl->addRole(new Role('admin'));
    }

    public function createResources()
    {
        $this->acl->addResource(new Resource('home'));
        $this->acl->addResource(new Resource('login'));
        $this->acl->addResource(new Resource('register'));
        $this->acl->addResource(new Resource('logout'));
        $this->acl->addResource(new Resource('my_profile'));
        $this->acl->addResource(new Resource('admin_dashboard'));
    }

    public function createPermissions()
    {
        $this->acl->allow('guest', 'home', 'GET');
        $this->acl->allow('guest', 'login', ['GET', 'POST']);
        $this->acl->allow('guest', 'register', ['GET', 'POST']);

        $this->acl->allow('member', 'logout', 'GET');
        $this->acl->allow('member', 'my_profile', 'GET');

        $this->acl->allow('admin');
    }

    public function check($role, $resource, $method)
    {
        return $this->acl->isAllowed($role, $resource, $method);
    }
}
