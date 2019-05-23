<?php

namespace ProviderBundle\Controller;

use FOS\RestBundle\View\View;
use ProviderBundle\Entity\Provider;
use ProviderBundle\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class ProviderController extends Controller
{
    /**
     * @Route("/providers")
     * @Method("GET")
     *
     */
    public function getProviders()
    {
        try {
            /** @var ProviderRepository $repo */
            $repo = $this->getDoctrine()->getRepository(Provider::class);
            $providers = $repo->findProviders();

            if ($providers === null) {
                throw new \Exception("there are no provider exist");
            }

            return $providers;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
