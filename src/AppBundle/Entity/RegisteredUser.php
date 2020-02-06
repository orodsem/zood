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

    const SALT = '44FABBH29691B6775F93B5C416F5C';

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
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    private $password_cofirmation;

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
     * @ORM\Column(name="is_available_interview", type="boolean", nullable=true)
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setEmail($str='')
    {
        $this->email = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setPassword($str='')
    {
        $this->password = $str;
        return $this;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setHashedPassword($str='')
    {
        $this->password = password_hash($str . self::SALT, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setPasswordConfirmation($str='')
    {
        $this->password_confirmation = $str;
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
        $this->created_at = $date ? $date : new \DateTime();
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
        $this->updated_at = $date ? $date : new \DateTime();
        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
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

    public function isEmailValid()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function isUserValid()
    {
        $this->messages = [];

        $re_name = "/^([a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*){1,255}$/";

        $re_email = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        // Minimum eight characters, at least one letter and one number:
        $re_pass = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

        if (!preg_match($re_name, $this->first_name))
            $this->messages['first_name'] = 'Invalid First Name';
        if (!preg_match($re_name, $this->last_name))
            $this->messages['last_name'] = 'Invalid Last Name';
        if (!preg_match($re_name, $this->country))
            $this->messages['country'] = 'Invalid Country';
        if (!preg_match($re_name, $this->city))
            $this->messages['city'] = 'Invalid Country';
        if (!preg_match($re_email, $this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $this->messages['email'] = 'Invalid Email';
        if (!preg_match($re_pass, $this->password))
            $this->messages['password'] = 'Invalid Passwords';
        if (!preg_match($re_pass, $this->password_confirmation))
            $this->messages['password'] = 'Invalid Passwords';
        if ($this->password != $this->password_confirmation)
            $this->messages['password'] = 'Invalid Passwords';


        return $this->messages ? false : true;
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

    /**
     * @return bool
     * @throws \Exception
     */
    public function isPasswordValid($str='')
    {


        return true;
    }

    public function clearToken()
    {
        $this->setToken(null);
        $this->setTokenExpiration(null);
        return;
    }


}
