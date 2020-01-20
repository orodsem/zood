<?php

namespace AppBundle\Controller;

use FOS\RestBundle\View\View;
use ProviderBundle\Entity\Provider;
use ProviderBundle\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\RegisteredUser;
use AppBundle\Repository\RegisteredUserRepository;

class HealthProviderController extends Controller
{

    private $messages = [];

    /**
     * @Route("/health-provider", name="healthProvider.index")
     */
    public function indexAction(Request $request)
    {
        $html = ($this->render('health-provider/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]));

        echo $html->getContent();
        exit;
    }

    /**
     * @Route("/health-provider/register", name="healthProvider.create")
     */
    public function registerAction(Request $request, $validationMessages=[])
    {
        $html = ($this->render('health-provider/register.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'postData' => $request->request->all()
        ]));

        echo $html->getContent();
        exit;
    }

    /**
     * @Route("/health-provider/store", name="healthProvider.store")
     */
    public function storeAction(Request $request)
    {
        $data = $request->request->all();
        $data['ip_address'] = $request->getClientIp();

        $valid = $this->isHealthProviderValid($data);

        if (!$valid) {

            $this->addFlash(
                'warning',
                $this->messages
            );
            return $this->redirectToRoute('healthProvider.create', [], 301);
        }

        $data = $this->updateOrCreate(['id' => @$data['id']], $data);

        $this->addFlash(
            'success',
            "Thank you for registration. Health provider's dashboard under construction"
        );

        return $this->redirectToRoute('healthProvider.index', [], 301);
    }

    public function updateOrCreate($where=[], $data=[])
    {

        $entityManager = $this->getDoctrine()->getManager();

        $regUser = $entityManager->getRepository(RegisteredUser::class)->findOneBy($where);

        if (!$regUser)
            $regUser = new RegisteredUser();

        $regUser->setIpAddress($data['ip_address']);
        $regUser->setEmail($data['email']);
        $regUser->setFirstName($data['first_name']);
        $regUser->setLastName($data['last_name']);
        $regUser->setType(isset($data['type']) ? $data['type'] : 'health provider');
        $regUser->setCountry($data['country']);
        $regUser->setCity($data['city']);
        $regUser->setProfession($data['profession']);
        $regUser->setBio($data['bio']);
        $regUser->setWorkingHours(json_encode($data['working_hours']));
        $regUser->setWorkingHoursStartDay($data['working_hours_start_day']);
        $regUser->setWorkingHoursEndDay($data['working_hours_end_day']);
        $regUser->setServicesOffered(json_encode($data['services_offered']));
        $regUser->setCalendarAvailability(json_encode($data['calendar_availability']));
        $regUser->setIsAvailableInterview(isset($data['is_available_interview']) ? $data['is_available_interview'] : false);
        $regUser->setCreatedAt();
        $regUser->setUpdatedAt();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($regUser);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $data;
    }


    public function isHealthProviderValid($data)
    {
        $valid = true;

        $this->messages = [];

        $validEmail = $this->isEmailValid($data['email']);

        if (!$validEmail) {
            $valid = false;
            $this->messages[] = 'Invalid Email';
        }

        if (!isset($data['first_name']) || strlen(trim($data['first_name'])) < 1 || strlen(trim($data['first_name'])) > 255) {
            $valid = false;
            $this->messages[] = 'Invalid First Name';
        }

        if (!isset($data['last_name']) || strlen(trim($data['first_name'])) < 1 || strlen(trim($data['last_name'])) > 255) {
            $valid = false;
            $this->messages[] = 'Invalid Last Name';
        }

        $countriesJson = file_get_contents($this->get('kernel')->getRootDir() . '/../web/data/countries-and-cities.json');

        if (!isset($data['country'])) {
            $valid = false;
            $this->messages[] = 'Invalid Country1';
        } else {

            if (!$countriesJson) {
                $valid = false;
                $this->messages[] = 'Invalid Country2';
            } else {
                $countriesArr = json_decode($countriesJson);
                $validCountry = false;
                foreach($countriesArr as $k => $v) {
                    if ($k == $data['country']) {
                        $validCountry = true;
                        break;
                    }
                }

                if (!$validCountry) {
                    $valid = false;
                    $this->messages[] = 'Invalid Country3';
                }
            }
        }

        if (!isset($data['city'])) {
            $valid = false;
            $this->messages[] = 'Invalid City1';
        } else {
            if (!$countriesJson) {
                $valid = false;
                $this->messages[] = 'Invalid City';
            } else {
                $citiesArr = (array)json_decode($countriesJson);
                $validCity = false;
                foreach($citiesArr[$data['country']] as $k => $v) {
                    if ($v == $data['city']) {
                        $validCity = true;
                        break;
                    }
                }

                if (!$validCity) {
                    $valid = false;
                    $this->messages[] = 'Invalid City';
                }
            }
        }

        if (!isset($data['working_hours']) || is_array($data['working_hours']) == false || count($data['working_hours']) < 1) {
            $valid = false;
            $this->messages[] = 'Invalid Working Hours';
        }

        if (!isset($data['services_offered']) || is_array($data['services_offered']) == false || count($data['services_offered']) < 1) {
            $valid = false;
            $this->messages[] = 'Invalid Services Offered';
        }

        if (!isset($data['calendar_availability']) || is_array($data['calendar_availability']) == false || count($data['calendar_availability']) < 1) {
            $valid = false;
            $this->messages[] = 'Invalid Calendar Availability';
        }

        return $valid;
    }

    /**
     * @Route("/health-provider/search", name="healthProvider.search")
     */
    public function searchAction(Request $request)
    {

        $errorMessage = '';
        $recaptchaKey = '';
        $searchResults = [];

        if ($_POST) {

            // $recaptchaKey = $this->container->getParameter('recaptcha_key');
            // $validReCaptcha = $this->validateReCaptcha($data);

            $data = $request->request->all();

            $entityManager = $this->getDoctrine()->getManager();

            $professionQueryStr = '';
            $professionQueryArr = [];
            if ($data['looking_for']) {
                foreach ($data['looking_for'] as $v) {
                    $professionQueryArr[] = " r.profession LIKE '%$v%' ";
                }
            }
            $professionQueryStr = $professionQueryArr ? ' WHERE ' . implode(" AND ", $professionQueryArr) : '';

            $countryQueryStr = '';
            $countryQueryStr = isset($data['country']) && $data['country'] ? " OR r.country IN ('". implode("','", $data['country']) ."')" : '';
            $countryQueryStr = !$professionQueryStr && $countryQueryStr ? ' WHERE '.$countryQueryStr : $countryQueryStr;

            $availabilityStr = '';

            $query = "
                SELECT r
                FROM AppBundle:RegisteredUser r
                $professionQueryStr
                $countryQueryStr
                $availabilityStr
            ";

            $searchResults = $entityManager->createQuery($query)->getResult();
        }


        $html = ($this->render('health-provider/search.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'recaptcha_key' => $recaptchaKey,
            'errorMessage' => $errorMessage,
            'searchResults' => $searchResults
        ]));

        echo $html->getContent();
        exit;
    }

    /**
     * validate recaptcha $data[g-recaptcha]
     */
    protected function validateReCaptcha(array $data=[])
    {
        $token = isset($data['g-recaptcha']) ? $data['g-recaptcha'] : '';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'secret' => $this->container->getParameter('recaptcha_secret'),
            'response' => $token,
        ]);

        $resp = json_decode(curl_exec($ch));
        curl_close($ch);

        var_dump(curl_exec($ch));die;

        return $resp->success ? true : false;
    }

    /**
     * @Route("/health-provider/email-validate", name="healthProvider.validateEmail")
     */
    public function validateEmialAction(Request $request)
    {

        $email = trim($request->get('email'));

        $validEmail = $this->isEmailValid($email);

        if (!$validEmail) {
            // already registered
            return new JsonResponse(['message' => 'Email already registered', 'result' => Response::HTTP_OK, 'data' => ['valid' => false]]);
        }

        return new JsonResponse(['message' => '', 'result' => Response::HTTP_OK, 'data' => ['valid' => $validEmail]]);
    }

    private function isEmailValid($email='')
    {

        $regEx = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        $valid = preg_match($regEx, $email);

        /** @var RegisteredUserRepository $repo */
        $repo = $this->getDoctrine()->getRepository(RegisteredUser::class);
        $user = $repo->findBy(['email' => $email]);

        return !empty($user) ? false : true;
    }

    /**
     * @Route("/health-provider/country-search", name="healthProvider.countrySearch")
     */
    public function countrySearchAction(Request $request)
    {
        $token = $request->get('token');

        $isValidToken = $this->isCsrfTokenValid('register', $token);

        if (!$isValidToken) {
            return new JsonResponse(["results" => []]);
            exit;
        }

        $search = trim($request->get('search'));

        $countriesJson = file_get_contents($this->get('kernel')->getRootDir() . '/../web/data/countries-and-cities.json');

        if (!$countriesJson) {
            return new JsonResponse(["results" => []]);
            exit;
        }

        $countriesArr = json_decode($countriesJson);

        $countries = [];

        foreach($countriesArr as $k => $v) {
            if (count($countries) > 10)
                break;
            if (strpos(strtolower($k), strtolower($search)) !== false)
                $countries[] = ['id' => $k, 'text' => $k];
        }

        return new JsonResponse(["results" => $countries]);
        exit;
    }

    /**
     * @Route("/health-provider/city-search", name="healthProvider.citySearch")
     */
    public function citySearchAction(Request $request)
    {

        $token = $request->get('token');

        $search = trim($request->get('search'));
        $country = trim($request->get('country'));

        $isValidToken = $this->isCsrfTokenValid('register', $token);

        if (!$isValidToken) {
            return new JsonResponse(["results" => []]);
            exit;
        }

        $citiesJson = file_get_contents($this->get('kernel')->getRootDir() . '/../web/data/countries-and-cities.json');

        if (!$citiesJson) {
            return new JsonResponse(["results" => []]);
            exit;
        }

        if (!$country) {
            return new JsonResponse(["results" => []]);
            exit;
        }

        $citiesArr = json_decode($citiesJson);

        if (!isset($citiesArr->$country)) {
            return new JsonResponse(["results" => []]);
            exit;
        }

        $cities = [];

        foreach($citiesArr->$country as $v) {
            if (count($cities) > 10)
                break;
            if (strpos(strtolower($v), strtolower($search)) !== false)
                $cities[] = ['id' => $v, 'text' => $v];
        }

        return new JsonResponse(["results" => $cities]);
        exit;
    }

}
