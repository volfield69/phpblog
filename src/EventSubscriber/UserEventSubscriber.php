<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Event\Events;
use App\Event\UserEvent;
use App\Security\SecurityManager;
use App\Service\Mailing\AuthMailer;
use DateTimeImmutable;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthMailer
     */
    private $mailer;
    /**
     * @var SecurityManager
     */
    private $securityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * UserEventSubscriber constructor.
     *
     * @param AuthMailer      $mailer
     * @param SecurityManager $securityManager
     * @param RouterInterface $router
     */
    public function __construct(
        AuthMailer $mailer,
        SecurityManager $securityManager,
        RouterInterface $router,
        ObjectManager $manager
    ) {
        $this->mailer = $mailer;
        $this->securityManager = $securityManager;
        $this->router = $router;
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::USER_RESET_PASSWORD => 'onUserResetPassword',
            Events::USER_RESET_PASSWORD_BACK => 'onUserResetPasswordBack',
            Events::USER_CREATE_NEW => 'onUserCreateNewSendConfirmationToken',
            Events::USER_REGISTRATION_COMPLETED => 'onUserRegistrationCompleted',
            Events::USER_SECURITY_LOGIN => 'onUserLogin',
        ];
    }

    /**
     * @param GenericEvent $event
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onUserResetPassword(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
        $this->mailer->sendResetMail($user);
    }

    /**
     * @param GenericEvent $event
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onUserResetPasswordBack(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
        $this->mailer->sendResetMail($user, true);
    }

    /**
     * @param GenericEvent $event
     */
    public function onUserCreateNewSendConfirmationToken(GenericEvent $event): void
    {
        /** @var User[] $user */
        $users = $event->getSubject();
        // Notification de tous les utilisateurs créés
        array_map(function ($user) {
            $this->mailer->sendNewUserCreationMail($user);
        }, $users);
    }

    /**
     * @param UserEvent $event
     */
    public function onUserRegistrationCompleted(UserEvent $event): void
    {
        $response = new RedirectResponse($this->router->generate('front_dashboard'));
        $event->setResponse($response);

        try {
            $this->securityManager->logUserIn($event->getUser(), $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * @param UserEvent $event
     *
     * @throws Exception
     */
    public function onUserLogin(UserEvent $event): void
    {
        /** @var User|UserInterface $user */
        $user = $event->getUser();
        $user->setLastLogin(new DateTimeImmutable());
        $this->manager->persist($user);
        $this->manager->flush();
    }
}
