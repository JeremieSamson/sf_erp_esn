<?php

namespace ESN\LoginBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use phpCAS;

class UserProvider implements UserProviderInterface
{
    private $casHost;
    private $casPort;
    private $casContext;

    public function __construct($casHost, $casPort, $casContext)
    {
        $this->casHost = $casHost;
        $this->casPort = $casPort;
        $this->casContext = $casContext;
    }

    public function loadUserFromCas(){
        phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, $this->casHost, $this->casPort, $this->casContext, false);
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();

        $username =  phpCAS::getUser();

        if ($username) {
            $attributes = phpCAS::getAttributes();

            return new User($username, $attributes, null, null, []);
        }

        return null;
    }

    public function loadUserByUsername($username)
    {
        phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, $this->casHost, $this->casPort, $this->casContext);
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();

        $username =  phpCAS::getUser();

        if ($username) {
            $attributes = phpCAS::getAttributes();

            return new User($username, $attributes, null, null, array());
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function logout($cas_host, $cas_port, $cas_context){
        phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
        phpCAS::logout();
        return true;
    }

    public function supportsClass($class)
    {
        return $class === 'ESN\LoginBundle\Security\User\UserProvider';
    }


}