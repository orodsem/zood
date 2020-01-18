<?php


namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\RegisteredUser;

class RegisteredUserRepository extends EntityRepository
{
    // /**
    //  * @var array
    //  */
    // private $messages = [];
    //
    // public function getMessages()
    // {
    //     return $this->messages;
    // }
    //
    // public function isHealthProviderValid($data)
    // {
    //     $valid = true;
    //
    //     $this->messages = [];
    //
    //     if (!isset($data['first_name']) || strlen(trim($data['first_name'])) < 1 || strlen(trim($data['first_name'])) > 255) {
    //         $valid = false;
    //         $this->messages[] = 'Invalid First Name';
    //     }
    //
    //     if (!isset($data['last_name']) || strlen(trim($data['first_name'])) < 1 || strlen(trim($data['last_name'])) > 255) {
    //         $valid = false;
    //         $this->messages[] = 'Invalid Last Name';
    //     }
    //
    //     $countriesJson = file_get_contents($this->get('kernel')->getRootDir() . '/../web/data/countries-and-cities.json');
    //
    //     if (!isset($data['country'])) {
    //         $valid = false;
    //         $this->messages[] = 'Invalid Country1';
    //     } else {
    //
    //         if (!$countriesJson) {
    //             $valid = false;
    //             $this->messages[] = 'Invalid Country2';
    //         } else {
    //             $countriesArr = json_decode($countriesJson);
    //             $validCountry = false;
    //             foreach($countriesArr as $k => $v) {
    //                 if ($k == $data['country']) {
    //                     $validCountry = true;
    //                     break;
    //                 }
    //             }
    //
    //             if (!$validCountry) {
    //                 $valid = false;
    //                 $this->messages[] = 'Invalid Country3';
    //             }
    //         }
    //     }
    //
    //     if (!isset($data['city'])) {
    //         $valid = false;
    //         $this->messages[] = 'Invalid City1';
    //     } else {
    //         if (!$countriesJson) {
    //             $valid = false;
    //             $this->messages[] = 'Invalid City';
    //         } else {
    //             $citiesArr = (array)json_decode($countriesJson);
    //             $validCity = false;
    //             foreach($citiesArr[$data['country']] as $k => $v) {
    //                 if ($v == $data['city']) {
    //                     $validCity = true;
    //                     break;
    //                 }
    //             }
    //
    //             if (!$validCity) {
    //                 $valid = false;
    //                 $this->messages[] = 'Invalid City';
    //             }
    //         }
    //     }
    //
    //     if (!isset($data['working_hours']) || is_array($data['working_hours']) == false || count($data['working_hours']) < 1) {
    //         $valid = false;
    //         $this->messages[] = 'Invalid Working Hours';
    //     }
    //
    //     if (!isset($data['services_offered']) || is_array($data['services_offered']) == false || count($data['services_offered']) < 1) {
    //         $valid = false;
    //         $this->messages[] = 'Invalid Services Offered';
    //     }
    //
    //     if (!isset($data['calendar_availability']) || is_array($data['calendar_availability']) == false || count($data['calendar_availability']) < 1) {
    //         $valid = false;
    //         $this->messages[] = 'Invalid Calendar Availability';
    //     }
    //
    //     return $valid;
    // }
    //
    // public function updateOrCreate($where=[], $val=[])
    // {
    //
    //     $entityManager = $this->getDoctrine()->getManager();
    //
    //     $regUser = $entityManager->getRepository(RegisteredUser::class)->findOneBy($where);
    //
    //    if (!$product)
    //       $regUser = $entityManager->getRepository(RegisteredUser::class);
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
