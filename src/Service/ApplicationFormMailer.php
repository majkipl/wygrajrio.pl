<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ApplicationFormMailer
{
    /**
     * @param MailerInterface $mailer
     * @param Environment $twig
     */
    public function __construct(private MailerInterface $mailer, private Environment $twig) {}

    /**
     * @param $formData
     * @return void
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendEmail($formData): void
    {
        $plain = $this->twig->render('email/plain/application.html.twig');

        $email = (new TemplatedEmail())
            ->from($_ENV['MAIL_SENDER_EMAIL'])
            ->to($formData->getEmail())
            ->subject('WygrajRio.pl : Dziękujemy za potwierdzenie zgłoszenia.')
            ->text($plain)
            ->htmlTemplate('email/html/application.html.twig');

        $this->mailer->send($email);
    }
}