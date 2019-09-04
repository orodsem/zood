<?php

namespace ProviderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity(repositoryClass="ProviderBundle\Repository\ProviderRepository")
 */
class Provider
{
    const SALT = '44FABEE29691B6DF5F93B5C416F5C';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="deleted", type="boolean", options={"default":"0"}))
     */
    private $deleted;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var \DateTime $token_expiration
     *
     * @ORM\Column(name="token_expiration", type="datetime", nullable=true)
     */
    private $token_expiration;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Provider
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Provider
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Provider
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Provider
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param string $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getTokenExpiration()
    {
        return $this->token_expiration;
    }

    /**
     * @param \DateTime $token_expiration
     */
    public function setTokenExpiration($token_expiration)
    {
        $this->token_expiration = $token_expiration;
    }

    /**
     *
     */
    public function generateToken()
    {
        $token = password_hash($this->getEmail() . self::SALT, PASSWORD_BCRYPT);
        $this->setToken($token);

        $date = new \DateTime();
        $date->modify('+4 hours');
        $this->setTokenExpiration($date);
        return;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isTokenValid()
    {
        if (empty($this->getToken())) {
            return false;
        }

        $now = new \DateTime();
        if ($this->getTokenExpiration() < $now) {
            return false;
        }

        return true;
    }

    public function clearToken()
    {
        $this->setToken(null);
        $this->setTokenExpiration(null);
        return;
    }
}
