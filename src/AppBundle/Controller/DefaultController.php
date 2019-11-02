<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RegisteredUser;
use AppBundle\Repository\RegisteredUserRepository;
use FOS\RestBundle\View\View;
use ProviderBundle\Entity\Provider;
use ProviderBundle\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $html = ($this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]));

        echo $html->getContent();
        exit;
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $email = $this->get('session')->get('email');

        if ($email === null) {
            // no access and back to homepage
            $this->indexAction($request);
        }

        // replace this example code with whatever you need
        $html = ($this->render('default/dashboard.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]));

        echo $html->getContent();
        exit;
    }

    /**
     * @Route("/about-us", name="aboutUs")
     */
    public function aboutUsAction(Request $request)
    {
        // replace this example code with whatever you need
        $html = ($this->render('default/about-us.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]));

        echo $html->getContent();
        exit;
    }

    /**
     * @Route("/register", name="register")
     * @Method("GET")
     *
     * @param Request $request
     * @return View
     */
    public function registerAction(Request $request)
    {
        try {
            $clientIpAddress = $request->getClientIp();
            $email = $request->get('email', null);

            if (empty($email)) {
                return new View(RegisteredUser::REGISTRATION_SUCCESS_MESSAGE, Response::HTTP_OK);
            }

            /** @var RegisteredUserRepository $repo */
            $repo = $this->getDoctrine()->getRepository(RegisteredUser::class);
            $registeredUser = $repo->findBy(['email' => $email]);

            if (!empty($registeredUser)) {
                // already registered
                return new View(RegisteredUser::REGISTRATION_SUCCESS_MESSAGE, Response::HTTP_OK);
            }

            $registeredUser = new RegisteredUser();
            $registeredUser->setEmail($email);
            $registeredUser->setIpAddress($clientIpAddress);

            if (!$registeredUser->isEmailValid()) {
                // invalid email
                return new View(RegisteredUser::REGISTRATION_SUCCESS_MESSAGE, Response::HTTP_OK);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($registeredUser);
            $em->flush();

            return new View(RegisteredUser::REGISTRATION_SUCCESS_MESSAGE, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

//        // Create the message
//        $emailMessage = (new \Swift_Message('Recovery Link'))
//            ->setFrom('orod@beeagile.com.au', 'DitttO')
//            ->setTo('orodsem@gmail.com')
//            ->setBody(
//                'hello ooooo'
//            );
//
//        $this->get('mailer')->send($emailMessage);
    }



}
