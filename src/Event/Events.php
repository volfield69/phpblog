<?php

namespace App\Event;

final class Events
{
    /**
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    public const USER_RESET_PASSWORD = 'user.reset_password';
    public const USER_RESET_PASSWORD_BACK = 'user.reset_password_back';
    public const USER_CREATE_NEW = 'user.create_new';
    public const USER_CREATE_NEW_PROJECT = 'user.create_new_project';
    public const USER_REGISTRATION_COMPLETED = 'user.registration_completed';
    public const USER_SECURITY_LOGIN = 'user.login';
    public const MEDICAL_ACCEPTANCE_SUBMISSION = 'emprunteur.project.medical_acceptance_submission';
}
