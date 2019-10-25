<?php

namespace App\Service\Mailing;

use App\Entity\User;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MailerUser.
 */
class MailerUser
{
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $templater;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(Mailer $mailer, Environment $templater, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->templater = $templater;
        $this->router = $router;
    }

    /**
     * @param Emprunteur $user
     * @param Selection  $selection
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendStudyProjectFirstPricing(User $user): void
    {
        /*$url = $this->router->generate('front_router_forward_step0', ['uuid' => $selection->getUuid()]);
        $subject =self::STUDY_PROJECT_HEADING;
        $templateToRenderBody = $this->templater->render('email/front/first_pricing_study_project.html.twig', [
            'user' => $user,
            'selection' => $selection,
            'url' => $url,
        ]);
        $courtier = $selection->getCourtier() ? $selection->getCourtier()->getEmail() : null;
        $this->mailer->sendGenericMail($templateToRenderBody, $subject, $user->getEmail(), $this->mailer->getSender(), $courtier);*/
    }
}
