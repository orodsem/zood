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
    const REGISTRATION_SUCCESS_MESSAGE = "Thanks for showing your interest. We'll be in touch with you shortly";

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
     * @ORM\Column(name="ip_address", type="string", length=255)
     */
    private $ip_address;

    /**
     * @var string
     *
     * @ORM\Column(name="registered_at", type="datetime", nullable=true)
     */
    private $registeredAt;

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

    private $messages = [];

    /**
     * @var string
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;

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

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * @param string $ip_address
     * @return $this
     */
    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return $this
     */
    public function setFirstName($str='')
    {
        $this->first_name = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setLastName($str='')
    {
        $this->last_name = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($str='')
    {
        $this->type = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry($str='')
    {
        $this->country = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCity($str='')
    {
        $this->city = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setProfession($str='')
    {
        $this->profession = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     * @return $this
     */
    public function setBio($str='')
    {
        $this->bio = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkingHours()
    {
        return $this->working_hours;
    }

    /**
     * @param string $working_hours
     * @return $this
     */
    public function setWorkingHours($str='')
    {
        $this->working_hours = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkingHoursStartDay()
    {
        return $this->working_hours_start_day;
    }

    /**
     * @param string $working_hours_start_day
     * @return $this
     */
    public function setWorkingHoursStartDay($str='')
    {
        $this->working_hours_start_day = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getWorkingHoursEndDay()
    {
        return $this->working_hours_end_day;
    }

    /**
     * @param string $working_hours_end_day
     * @return $this
     */
    public function setWorkingHoursEndDay($str='')
    {
        $this->working_hours_end_day = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getServicesOffered()
    {
        return $this->services_offered;
    }

    /**
     * @param string $services_offered
     * @return $this
     */
    public function setServicesOffered($str='')
    {
        $this->services_offered = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarAvailability()
    {
        return $this->calendar_availability;
    }

    /**
     * @param string $calendar_availability
     * @return $this
     */
    public function setCalendarAvailability($str='')
    {
        $this->calendar_availability = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsAvailableInterview()
    {
        return $this->is_available_interview;
    }

    /**
     * @param string $is_available_interview;
     * @return $this
     */
    public function setIsAvailableInterview($bool=false)
    {
        $this->is_available_interview = $bool;
        return $this;
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
    public function setCreatedAt($date='')
    {
        $this->created_at = $date ? $date : date('Y-m-d H:i:s');
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($date='')
    {
        $this->updated_at = $date ? $date : date('Y-m-d H:i:s');
        return $this;
    }

    // public function getMessages()
    // {
    //     return $this->messages;
    // }

    public function isEmailValid()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }


    // public function updateOrCreate($where=[], $val=[])
    // {
    //
    //     $entityManager = $this->getDoctrine()->getManager();
    //
    //     $regUser = $entityManager->getRepository($this)->findOneBy($where);
    //
    //    if (!$product)
    //       $regUser = $entityManager->getRepository($this);
    //
    //     $regUser->setLastName($data['email']);
    //     $regUser->setFirstName($data['first_name']);
    //     $regUser->setLastName($data['last_name']);
    //     $regUser->setType($data['type']);
    //     $regUser->setCountry($data['country']);
    //     $regUser->setCity($data['city']);
    //     $regUser->setProfession($data['profession']);
    //     $regUser->setBio($data['bio']);
    //     $regUser->setWorkingHours($data['working_hours']);
    //     $regUser->setWorkingHoursStartDay($data['working_hours_start_day']);
    //     $regUser->setWorkingHoursEndDay($data['working_hours_end_day']);
    //     $regUser->setServicesOffered($data['services_offered']);
    //     $regUser->setCalendarAvailability($data['calendar_availability']);
    //     $regUser->setIsAvailableInterview($data['is_available_interview']);
    //     $regUser->setCreatedAt();
    //     $regUser->setUpdatedAt();
    //
    //     // tells Doctrine you want to (eventually) save the Product (no queries yet)
    //     $entityManager->persist($regUser);
    //
    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();
    //
    //     return $data;
    // }

}
