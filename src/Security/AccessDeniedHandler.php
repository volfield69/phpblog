<?php

namespace App\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public const CUSTOM_DENY_MESSAGE = 'denied_then_redirect_step0';
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(FlashBagInterface $flashBag, TranslatorInterface $translator, RouterInterface $router)
    {
        $this->flashBag = $flashBag;
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * Handles an access denied failure.
     *
     * @param Request               $request
     * @param AccessDeniedException $accessDeniedException
     *
     * @return RedirectResponse
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
    {
        if (($requestAttributes = $request->attributes) && $requestAttributes->has('_security')) {
            /** @var Security $security */
            $security = current($requestAttributes->get('_security'));
            $uuid = $requestAttributes->has('uuid') ? $requestAttributes->get('uuid') : null;

            if ($uuid && $security && self::CUSTOM_DENY_MESSAGE === $security->getMessage()) {
                return new RedirectResponse($this->router->generate('front_router_forward_step0', ['uuid' => $uuid]));
            }
        }

        $this->flashBag->add('danger', $this->translator->trans('user.ungranted.resource'));

        return new RedirectResponse($this->router->generate('front_dashboard'));
    }
}
