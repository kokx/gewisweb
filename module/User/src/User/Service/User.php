<?php

namespace User\Service;

use User\Model\User as UserModel,
    User\Mapper\User as UserMapper;

use Zend\ServiceManager\ServiceManager,
    Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * User service.
 */
class User implements ServiceManagerAwareInterface
{

    /**
     * Service manager.
     *
     * @var ServiceManager
     */
    protected $sm;

    /**
     * Log the user in.
     *
     * @param array $data Login data
     *
     * @return UserModel Authenticated user. Null if not authenticated.
     */
    public function login($data)
    {
        $form = $this->getLoginForm();

        $form->setData($data);

        if (!$form->isValid()) {
            return null;
        }

        // try to authenticate
        $auth = $this->getServiceManager()->get('user_auth_service');
        $authAdapter = $auth->getAdapter();

        $authAdapter->setCredentials($form->getData());

        $result = $auth->authenticate();

        // process the result
        if (!$result->isValid()) {
            $form->setResult($result);
            return null;
        }

        return $auth->getIdentity();
    }

    /**
     * Get the login form.
     *
     * @return LoginForm Login form
     */
    public function getLoginForm()
    {
        return $this->sm->get('user_form_login');
    }

    /**
     * Get the user mapper.
     *
     * @return UserMapper
     */
    public function getUserMapper()
    {
        return $this->sm->get('user_mapper_user');
    }

    /**
     * Set the service manager.
     *
     * @param ServiceManager $sm
     */
    public function setServiceManager(ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    /**
     * Get the service manager.
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->sm;
    }
}
