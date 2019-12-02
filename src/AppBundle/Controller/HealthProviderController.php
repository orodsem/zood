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
    public function registerAction(Request $request)
    {
        $html = ($this->render('health-provider/register.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]));

        echo $html->getContent();
        exit;
    }

    /**
     * @Route("/health-provider/email-validate", name="healthProvider.validateEmail")
     */
    public function validateEmialAction(Request $request)
    {

        $email = trim($request->get('email'));

        $regEx = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        $valid = preg_match($regEx, $email);

        echo json_encode(['message' => '', 'result' => Response::HTTP_OK, 'data' => ['valid' => $valid]]);

        exit;
    }

    /**
     * @Route("/health-provider/counries-search", name="healthProvider.countriesSearch")
     */
    public function countriesSearchAction(Request $request)
    {

        $search = trim($request->get('search'));

        $countriesJson = file_get_contents($this->get('kernel')->getRootDir() . '/../web/data/countries-and-cities.json');

        if (!$countriesJson) {
            echo json_encode(['message' => 'Countries and cities not found.', 'result' => Response::HTTP_BAD_REQUEST, 'data' => null]);
            exit;
        }

        $countriesArr = json_decode($countriesJson);

        $countries = [];

        foreach($countriesArr as $k => $v) {

            if (count($countries) > 10)
                break;
            if (strpos($k, $search) !== false)
                $countries[] = $k;
        }

        if (count($countries) < 1) {
            foreach($countriesArr as $k => $v) {
                if (count($countries) > 10)
                    break;
                    
                $countries[] = $k;
            }
        }

        echo json_encode(['message' => '', 'result' => Response::HTTP_OK, 'data' => $countries]);

        exit;
    }

}
