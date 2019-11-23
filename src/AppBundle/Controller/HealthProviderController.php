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
     * @Route("/health-provider/register", name="healthProvider.register")
     */
    public function registerAction(Request $request)
    {
        $html = ($this->render('health-provider/register.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]));

        echo $html->getContent();
        exit;
    }

}
