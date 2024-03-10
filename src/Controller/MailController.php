<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class MailController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/send_mail', name: 'app_mail')]
    public function send(MailerInterface $mailer): JsonResponse
    {
        $email = (new Email())
            ->from('mailer@detailingof.ru')
            ->to('3hr@qmotors.ru')
            ->cc('89853148967@mail.ru')
            ->subject('Отклик на вакансию "Моторист"')
            ->text('Заказ звонка')
            ->html(
                '<h2>Заказать звонок</h2><p></p><p>Имя: ' . $_REQUEST["username"] . '</p><p>Номер телефона: ' . $_REQUEST["phone"] . '</p>'
            );

        $mailer->send($email);
        return new JsonResponse(['success' => true]);
    }
}