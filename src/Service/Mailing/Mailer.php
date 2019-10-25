<?php

namespace App\Service\Mailing;

use Psr\Log\LoggerInterface;
use Swift_Mailer as BaseMailer;
use Swift_Message;
use Swift_Mime_SimpleMessage;

class Mailer
{
    /**
     * @var BaseMailer
     */
    private $mailer;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string
     */
    private $sender;

    public function __construct(BaseMailer $mailer, LoggerInterface $logger, string $sender)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->sender = $sender;
    }

    /**
     * @param string       $templateToRenderBody
     * @param string       $subject
     * @param array|string $toEmail
     * @param string       $fromEmail
     * @param null|string  $ccEmail
     */
    public function sendGenericMail(string $templateToRenderBody, string $subject, $toEmail, string $fromEmail, string $ccEmail = null): void
    {
        $message = (new Swift_Message())
            ->setPriority(Swift_Mime_SimpleMessage::PRIORITY_HIGHEST)
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($templateToRenderBody, 'text/html')
        ;

        if ($ccEmail) {
            $message->addCc($ccEmail);
        }

        $failure = [];
        if (!$this->mailer->send($message, $failure)) {
            $this->logger->error(
                "Erreur envoi mail pour le mail: {$toEmail}"
            );
        } else {
            $this->logger->info(
                "Mail envoyé à l'adresse: {$toEmail}"
            );
        }
        //si besoin de relancer les mails loupés sinon on enlève les failures
        // @TODO il exite d'aures outils comme le component Meseenger pour gérer les envois,
        // @TODO les mettre dans des queues, les relancer quand ca echoue...
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }
}
