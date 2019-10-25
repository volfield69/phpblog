<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuActiveExtension extends AbstractExtension
{
    private const TWIG_EXTENSION_NAME = 'activeMenu';
    private const MENU_ACTIVE = 'active';
    private const MENU_NOT_ACTIVE = 'inactive';

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * MenuActiveExtension constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(self::TWIG_EXTENSION_NAME, [$this, self::TWIG_EXTENSION_NAME]),
        ];
    }

    /**
     * @param array $routesToCheck
     *
     * @return string
     */
    public function activeMenu(array $routesToCheck): string
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');

        foreach ($routesToCheck as $routeToCheck) {
            if ($routeToCheck === $currentRoute) {
                return self::MENU_ACTIVE;
            }
        }

        return self::MENU_NOT_ACTIVE;
    }
}
