<?php

namespace App\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserEvent extends Event
{
    /**
     * @var UserInterface
     */
    protected $user;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    private $response;

    /**
     * UserEvent constructor.
     *
     * @param UserInterface $user
     * @param null|Request  $request
     * @param null|Response $response
     */
    public function __construct(UserInterface $user, Request $request = null, Response $response = null)
    {
        $this->user = $user;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @return Request
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return self
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }
}
