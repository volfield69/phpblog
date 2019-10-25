<?php

namespace App\Security;

use App\Event\Events;
use App\Event\UserEvent;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\FirewallMapInterface;
use Symfony\Component\Security\Http\RememberMe\RememberMeServicesInterface;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SecurityManager
{
    /**
     * @var UserChecker
     */
    private $userChecker;
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var SessionAuthenticationStrategyInterface
     */
    private $sessionAuthenticationStrategy;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var RememberMeServicesInterface
     */
    private $rememberMeServices;
    /**
     * @var FirewallMap
     */
    private $firewallMap;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * UserManager constructor.
     *
     * @param UserChecker                            $userChecker
     * @param RequestStack                           $requestStack
     * @param SessionAuthenticationStrategyInterface $sessionAuthenticationStrategy
     * @param TokenStorageInterface                  $tokenStorage
     * @param RememberMeServicesInterface            $rememberMeServices
     * @param FirewallMapInterface                   $firewallMap
     */
    public function __construct(UserChecker $userChecker, RequestStack $requestStack, SessionAuthenticationStrategyInterface $sessionAuthenticationStrategy, TokenStorageInterface $tokenStorage, RememberMeServicesInterface $rememberMeServices, FirewallMapInterface $firewallMap, EventDispatcherInterface $eventDispatcher)
    {
        $this->userChecker = $userChecker;
        $this->requestStack = $requestStack;
        $this->sessionAuthenticationStrategy = $sessionAuthenticationStrategy;
        $this->tokenStorage = $tokenStorage;
        $this->rememberMeServices = $rememberMeServices;
        $this->firewallMap = $firewallMap;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param UserInterface $user
     * @param null|Response $response
     */
    final public function logUserIn(UserInterface $user, Response $response = null): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if ((null !== $request) && ($firewall = $this->firewallMap->getFirewallConfig($request))) {
            $firewallName = $firewall->getName();
            $this->userChecker->checkPreAuth($user);
            $token = new UsernamePasswordToken($user, null, $firewallName, $user->getRoles());

            $this->sessionAuthenticationStrategy->onAuthentication($request, $token);

            if (null !== $response && null !== $this->rememberMeServices) {
                $this->rememberMeServices->loginSuccess($request, $response, $token);
            }
            $this->tokenStorage->setToken($token);
            $event = new UserEvent($user);
            $this->eventDispatcher->dispatch($event, Events::USER_SECURITY_LOGIN);
        }
    }
}
