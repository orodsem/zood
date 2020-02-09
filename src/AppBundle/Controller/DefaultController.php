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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
            // $this->indexAction($request);
            return $this->redirectToRoute('homepage', [], 308);
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
            $password = $request->get('password');

            /** @var RegisteredUserRepository $repo */
            $repo = $this->getDoctrine()->getRepository(RegisteredUser::class);
            $registeredUser = $repo->findOneBy(['email' => $email]);

            if (!empty($registeredUser))
                return new JsonResponse(["results" => [], "messages" => ['Email is already registered'], "status" => false]);

            $registeredUser = new RegisteredUser();
            $registeredUser->setIpAddress($clientIpAddress);
            $registeredUser->setType($request->get('type', null));
            $registeredUser->setFirstName($request->get('first_name', null));
            $registeredUser->setLastName($request->get('last_name', null));
            $registeredUser->setCountry($request->get('country', null));
            $registeredUser->setCity($request->get('city', null));
            $registeredUser->setEmail($email);
            $registeredUser->setPassword($password);
            $registeredUser->setPasswordConfirmation($request->get('password_confirmation', null));

            if (!$registeredUser->isUserValid())
                return new JsonResponse(["results" => [], "messages" => $registeredUser->getMessages(), "status" => false]);

            $encoderService = $this->container->get('security.password_encoder');
            $pass = $encoderService->encodePassword($registeredUser, $password);

            // if everything is valid, hash the password
            $registeredUser->setPassword($pass);

            $em = $this->getDoctrine()->getManager();
            $em->persist($registeredUser);
            $em->flush();

            return new JsonResponse(["results" => [], "messages" => [RegisteredUser::REGISTRATION_SUCCESS_MESSAGE], "status" => true]);
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
