<?php

namespace ProviderBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class ProviderController extends Controller
{
    /**
     * @Route("/provider")
     * @Method("GET")
     *
     */
    public function getProviders()
    {
        $restresult = $this->getDoctrine()->getRepository('ProviderBundle:Provider')->findAll();
        if ($restresult === null) {
            return new View("there are no provider exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}
