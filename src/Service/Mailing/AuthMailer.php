<?php

namespace App\Service\Mailing;

use App\Entity\User;
use App\Service\TokenGenerator;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AuthMailer
{
    private const COMPANY_OBJECT_EMAIL = 'Entoria';
    private const CREATE_ACCOUNT_MESSAGE = 'Création de votre compte';
    private const RESET_PASSWORD_MESSAGE = 'Mot de passe oublié';

    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $templater;
    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;

    public function __construct(Mailer $mailer, Environment $templater, TokenGenerator $tokenGenerator)
    {
        $this->mailer = $mailer;
        $this->templater = $templater;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @param User $user
     * @param bool $admin
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendResetMail(User $user, $admin = false): void
    {
        $url = $this->tokenGenerator->generateResetPasswordUrl($user, $admin);
        $subject = $this->getSubject($user, self::RESET_PASSWORD_MESSAGE);
        $templateToRenderBody = $this->templater->render('email/'.($admin ? 'back' : 'front').'/reset_password.html.twig', [
            'user' => $user,
            'url' => $url,
        ]);
        $this->mailer->sendGenericMail($templateToRenderBody, $subject, $user->getEmail(), $this->mailer->getSender());
    }

    /**
     * @param User $user
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendNewUserCreationMail(User $user): void
    {
        $url = $this->tokenGenerator->generateActivationNewUserUrl($user);

        $subject = $this->getSubject($user, self::CREATE_ACCOUNT_MESSAGE);

        $templateToRenderBody = $this->templater->render('email/front/new_user.html.twig', [
            'user' => $user,
            'url' => $url,
        ]);
        $this->mailer->sendGenericMail($templateToRenderBody, $subject, $user->getEmail(), $this->mailer->getSender());
    }

    /**
     * @param User $user
     * @param $message
     *
     * @return string
     */
    public function getSubject(User $user, string $message): string
    {
        return sprintf(
            '%s - %s - %s %s',
            self::COMPANY_OBJECT_EMAIL,
            $message,
            strtoupper($user->getNom()),
            $user->getPrenom()
        );
    }
}
