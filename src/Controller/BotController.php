<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BotController extends AbstractController
{
    const TOKEN = '7061105523:AAG_TsmypzumDdj7o29XcoDCTPBQSfbmv60';
    const CHATID = '-1002012952797';

    #[Route('/send_mail', name: 'app_mail')]
    public function send(Request $request): JsonResponse
    {
        $arr = [
            'Имя клиента: ' => $request->request->get('username'),
            'Телефон клиента: ' => $request->request->get('phone'),
            '%0AФорма была отправлена со страницы: ' => 'https://autocarplus.ru' . $request->request->get('page')
        ];

        $txt = '<u><b><i>В техцентр поступил запрос на обратный звонок. %0A%0A</i></b></u>';
        foreach ($arr as $key => $value) {
            $txt .= '<b>' . $key . '</b>' . $value . '%0A';
        }
        fopen('https://api.telegram.org/bot' . self::TOKEN . '/sendMessage?chat_id=' . self::CHATID . '&parse_mode=html&text=' . $txt, 'r');
        return new JsonResponse(['success' => true]);
    }
}