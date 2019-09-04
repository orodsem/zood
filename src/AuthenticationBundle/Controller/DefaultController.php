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

            // is password valid
            if ($provider->getPassword() === $password) {
                if (!$provider->isTokenValid()) {
                    // if token invalid, then generate one
                    $provider->generateToken();
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($provider);
                    $em->flush();
                }
                $this->get('session')->set('email', $provider->getEmail());
                return ['message' => 'Login success.', 'result' => Response::HTTP_OK, 'data' => ['url' => '/dashboard']];
            }

            return ['message' => 'Login failed. Invalid email or password.', 'result' => Response::HTTP_BAD_REQUEST];

        } catch (\InvalidArgumentException $e) {
            return ['message' => 'Login failed. Invalid email or password.', 'result' => Response::HTTP_BAD_REQUEST];
        } catch (NonUniqueResultException $e) {
            return ['message' => $e->getMessage(), 'result' => Response::HTTP_BAD_REQUEST];
        }
    }

    /**
     * @Route("/logout")
     * @Method("GET")
     *
     */
    public function logout(Request $request)
    {
        try {
            $email = $this->get('session')->get('email');
            if ($email === null) {
                throw new \InvalidArgumentException('email is empty');
            }

            /** @var ProviderRepository $repo */
            $repo = $this->getDoctrine()->getRepository(Provider::class);
            $provider = $repo->findProvidersByEmail($email);

            if (!$provider instanceof Provider) {
                throw new \InvalidArgumentException('No provider found for email [' . $email . ']');
            }

            $provider->clearToken();
            $this->get('session')->set('email', null);
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            // return to homepage
            $response = $this->forward('AppBundle\Controller\DefaultController::indexAction');

            return $response;

        } catch (\InvalidArgumentException $e) {
            // return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            return ['message' => 'Login failed. Invalid email or password.', 'result' => Response::HTTP_BAD_REQUEST];
        } catch (NonUniqueResultException $e) {
            // return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        return ['message' => $e->getMessage(), 'result' => Response::HTTP_BAD_REQUEST];
        }
    }
}
