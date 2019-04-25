<?php

namespace ESN\LoginBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class User implements UserInterface, EquatableInterface
{
    private $username;
    private $password;
    private $salt;
    private $roles;

    private $email;
    private $sc;
    private $firstName;
    private $lastName;
    private $nationality;
    private $picture;
    private $birthDate;
    private $gender;
    private $telephone;
    private $address;
    private $section;
    private $country;

    public function __construct($username, $attributes, $password = null, $salt = null, array $roles = [])
    {
        $this->username = $username;
        $this->email = $attributes['mail'];
        $this->sc = $attributes['sc'];
        $this->firstName = $attributes['first'];
        $this->lastName = $attributes['last'];
        $this->nationality = $attributes['nationality'];
        $this->roles = $attributes['roles'];
        $this->picture = $attributes['picture'];
        $this->birthDate = $attributes['birthdate'];
        $this->gender = $attributes['gender'];
        $this->telephone = array_key_exists('telephone', $attributes) ? $attributes['telephone'] : null;
        $this->section = $attributes['section'];
        $this->country = $attributes['country'];
        $this->password = $password;
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSc()
    {
        return $this->sc;
    }

    /**
     * @param mixed $sc
     */
    public function setSc($sc)
    {
        $this->sc = $sc;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstname($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastname($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthdate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}