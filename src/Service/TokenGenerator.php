<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class TokenGenerator
{
    /** @var TokenGeneratorInterface */
    private $tokenGenerator;

    /** @var ObjectManager */
    private $em;

    /** @var SessionInterface */
    private $session;

    /** @var LoggerInterface */
    private $logger;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * GenerateUserToken constructor.
     *
     * @param TokenGeneratorInterface $tokenGenerator
     * @param ObjectManager           $em
     * @param SessionInterface        $session
     * @param LoggerInterface         $logger
     * @param RouterInterface         $router
     */
    public function __construct(
        TokenGeneratorInterface $tokenGenerator,
        ObjectManager $em,
        SessionInterface $session,
        LoggerInterface $logger,
        RouterInterface $router
    ) {
        $this->tokenGenerator = $tokenGenerator;
        $this->em = $em;
        $this->session = $session;
        $this->logger = $logger;
        $this->router = $router;
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function generate(User $user): string
    {
        $token = $this->tokenGenerator->generateToken();

        try {
            $user->setResetToken($token);
            $this->em->flush();
        } catch (\Exception $e) {
            $this->logger->critical('Le token n\'a pas pu être enregistré en base de donnée : \n'.$e->getMessage());
        }

        return $token;
    }

    /**
     * @param User  $user
     * @param mixed $admin
     *
     * @return bool|string
     */
    public function generateResetPasswordUrl(User $user, $admin = false): string
    {
        $token = $this->generate($user);

        return $this->router->generate(
            $admin ? 'admin_reset_password' : 'app_reset_password',
            ['token' => $token],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * @param User $user
     *
     * @return bool|string
     */
    public function generateActivationNewUserUrl(User $user): string
    {
        $token = $this->generate($user);

        return $this->router->generate(
            'app_activate_set_password',
            ['token' => $token],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
