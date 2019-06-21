<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="registered_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegisteredUserRepository")
 */
class RegisteredUser
{
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
     * @ORM\Column(name="registered_at", type="datetime", nullable=true)
     */
    private $registeredAt;

    public function __construct()
    {
        $this->registeredAt = new \DateTime();
    }

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
     * @return $this
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
     * @return string
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * @param string $registeredAt
     * @return $this
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;
        return $this;
    }
}