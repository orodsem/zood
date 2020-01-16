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

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;

class HealthProviderController extends Controller
{
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

        $valid = true;

        $messages = [];

        if (!isset($data['first_name']) || strlen(trim($data['first_name'])) < 1 || strlen(trim($data['first_name'])) > 255) {
            $valid = false;
            $messages[] = 'Invalid First Name';
        }

        if (!isset($data['last_name']) || strlen(trim($data['first_name'])) < 1 || strlen(trim($data['last_name'])) > 255) {
            $valid = false;
            $messages[] = 'Invalid Last Name';
        }

        $countriesJson = file_get_contents($this->get('kernel')->getRootDir() . '/../web/data/countries-and-cities.json');

        if (!isset($data['country'])) {
            $valid = false;
            $messages[] = 'Invalid Country1';
        } else {

            if (!$countriesJson) {
                $valid = false;
                $messages[] = 'Invalid Country2';
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
                    $messages[] = 'Invalid Country3';
                }
            }
        }

        if (!isset($data['city'])) {
            $valid = false;
            $messages[] = 'Invalid City1';
        } else {
            if (!$countriesJson) {
                $valid = false;
                $messages[] = 'Invalid City';
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
                    $messages[] = 'Invalid City';
                }
            }
        }

        if (!isset($data['working_hours']) || is_array($data['working_hours']) == false || count($data['working_hours']) < 1) {
            $valid = false;
            $messages[] = 'Invalid Working Hours';
        }

        if (!isset($data['services_offered']) || is_array($data['services_offered']) == false || count($data['services_offered']) < 1) {
            $valid = false;
            $messages[] = 'Invalid Services Offered';
        }

        if (!isset($data['calendar_availability']) || is_array($data['calendar_availability']) == false || count($data['calendar_availability']) < 1) {
            $valid = false;
            $messages[] = 'Invalid Calendar Availability';
        }

        if (!$valid) {
            $this->addFlash(
                'warning',
                $messages
            );
            return $this->redirectToRoute('healthProvider.create', [], 301);
        }
        echo "<pre>";
        var_dump($data);
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setData($data);

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();


        die;

        // @todo: save new user
        // @todo: automatically login successful registered user

        exit;
    }

    /**
     * @Route("/health-provider/search", name="healthProvider.search")
     */
    public function searchAction(Request $request)
    {

        $errorMessage = '';
        $recaptchaKey = '';

        if ($_POST) {

            $recaptchaKey = $this->container->getParameter('recaptcha_key');

            $data = $request->request->all();

            $validReCaptcha = $this->validateReCaptcha($data);
            var_dump($validReCaptcha);die;
            if (!$validReCaptcha) {
                $errorMessage = 'Invalid ReCaptcha';
            }
        }

        $html = ($this->render('health-provider/search.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'recaptcha_key' => $recaptchaKey,
            'errorMessage' => $errorMessage
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

        $regEx = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        $valid = preg_match($regEx, $email);

        /** @var RegisteredUserRepository $repo */
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findBy(['email' => $email]);

        if (!empty($user)) {
            // already registered
            return new JsonResponse(['message' => 'Email already registered', 'result' => Response::HTTP_OK, 'data' => ['valid' => false]]);
        }

        return new JsonResponse(['message' => '', 'result' => Response::HTTP_OK, 'data' => ['valid' => $valid]]);
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
