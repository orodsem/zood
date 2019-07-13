<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RegisteredUser;
use FOS\RestBundle\View\View;
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
     * @Route("/register", name="register")
     * @Method("GET")
     *
     * @param Request $request
     * @return View
     */
    public function registerAction(Request $request)
    {
        try {
            $email = $request->get('email', null);

            if (empty($email)) {
                return new View('all good', Response::HTTP_OK);
            }

            $registeredUser = new RegisteredUser();
            $registeredUser->setEmail($email);

            $em = $this->getDoctrine()->getManager();


            $em->persist($registeredUser);
            $em->flush();

            return new View('all good', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_OK);
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
