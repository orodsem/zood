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

class UserController extends Controller
{
    /**
     * @Route("/profile", name="user.profile")
     */
    public function profileAction(Request $request)
    {
        $email = $this->get('session')->get('email');

        if ($email == null)
            return $this->redirectToRoute('homepage', [], 308);

        $repo = $this->getDoctrine()->getRepository(RegisteredUser::class);
        $user = $repo->findBy(['email' => $email]);
        $user = isset($user[0]) ? $user[0] : null;

        if (!$user)
            return $this->redirectToRoute('homepage', [], 308);

        $html = ($this->render('user/profile.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'postData' => $user
        ]));

        echo $html->getContent();
        exit;
    }
}
