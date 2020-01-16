<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", length=10000, nullable=true)
     */
    private $bio;

    /**
     * @var string
     *
     * @ORM\Column(name="working_hours", type="text", length=1000, nullable=true)
     * string array json in format
     */
    private $working_hours;

    /**
     * @var string
     *
     * @ORM\Column(name="working_hours_start_day", type="string", length=255, nullable=true)
     */
    private $working_hours_start_day;

    /**
     * @var string
     *
     * @ORM\Column(name="working_hours_end_day", type="string", length=255, nullable=true)
     */
    private $working_hours_end_day;

    /**
     * @var string
     *
     * @ORM\Column(name="working_hours_text", type="text", length=10000, nullable=true)
     * string array json in format
     */
    private $services_offered;

    /**
     * @var string
     *
     * @ORM\Column(name="calendar_availability", type="text", length=10000, nullable=true)
     * string array json in format
     */
    private $calendar_availability;

    /**
     * @var string
     *
     * @ORM\Column(name="is_available_interview", type="boolean")
     */
    private $is_available_interview;

    /**
     * @var string
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @var string
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct()
    {
        $this->$created_at = new \DateTime();
        $this->$updated_at = new \DateTime();
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

    public function setData(array $data=[])
    {
        if (!$data || empty($data))
            return false;

        foreach ($data as $k => $v):
            if (isset($this->$k))
                $this->$k = $v;
        endforeach;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function isEmailValid()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
}
