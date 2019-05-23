<?php

namespace AuthenticationBundle\Controller;

use Doctrine\ORM\NonUniqueResultException;
use FOS\RestBundle\View\View;
use ProviderBundle\Entity\Provider;
use ProviderBundle\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/authenticate")
     * @Method("POST")
     *
     */
    public function authenticate(Request $request)
    {
        try {
            $email = $request->get('email');
            $password = $request->get('password');

            if ($email === null || $password === null) {
                throw new \InvalidArgumentException('email/password is empty');
            }

            /** @var ProviderRepository $repo */
            $repo = $this->getDoctrine()->getRepository(Provider::class);
            $provider = $repo->findProvidersByEmail($email);

            if (!$provider instanceof Provider) {
                throw new \InvalidArgumentException('No provider found for email [' . $email . ']');
            }

            if ($provider->getPassword() === $password) {
                return new View('Successfully authenticated', Response::HTTP_OK);
            }

            return new View('Invalid credential given', Response::HTTP_OK);

        } catch (\InvalidArgumentException $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (NonUniqueResultException $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
