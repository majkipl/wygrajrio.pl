<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactFormMailer
{
    /**
     * @param MailerInterface $mailer
     */
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @param array $formData
     * @return void
     * @throws TransportExceptionInterface
     */
    public function sendContactEmail(array $formData): void
    {
        $email = (new Email())
            ->from($formData['email'])
            ->to($_ENV['MAIL_SENDER_EMAIL'])
            ->subject('Nowa wiadomość z formularza kontaktowego WygrajRio.Pl')
            ->text($this->generateEmailContent($formData));

        $this->mailer->send($email);
    }

    /**
     * @param array $formData
     * @return string
     */
    private function generateEmailContent(array $formData): string
    {
        // Tworzenie treści emaila na podstawie przesłanych danych
        $content = 'Nowa wiadomość kontaktowa:' . PHP_EOL . PHP_EOL;
        $content .= 'Imię: ' . $formData['firstname'] . PHP_EOL;
        $content .= 'Nazwisko: ' . $formData['lastname'] . PHP_EOL;
        $content .= 'Email: ' . $formData['email'] . PHP_EOL;
        $content .= 'Wiadomość: ' . $formData['message'] . PHP_EOL;

        return $content;
    }
}