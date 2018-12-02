<?php
/**
 * This file is part of App\Mailer for code
 *
 * @package    App\Mailer
 * @file       Contact.php
 * @date       02 12 2018 02:51
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2018 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace App\Mailer;

use Swift_Message;
use Swift_Mailer;
use App\Entity\ContactHydrator;
use Symfony\Component\HttpFoundation\RequestStack;

class SendEntityMail
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var string
     */
    const MAILER_STRING_SPLIT = '*******************************************************';

    /**
     * SendEntityMail constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param array        $entityData
     * @param Swift_Mailer $mailer
     */
    public function send(array $entityData, Swift_Mailer $mailer)
    {
        $request = $this->requestStack->getCurrentRequest();
        $stringRequest = $request->__toString();

        $body = ">>> New message received\r\n";
        $body .= self::MAILER_STRING_SPLIT . "\r\n";
        $body .= 'locale: ' . $request->getLocale() . "\r\n";
        foreach ($entityData as $key => $data) {
            $body .= "$key: $data\r\n";
        }
        $body .= "\r\n>>> Contextual request\r\n";
        $body .= self::MAILER_STRING_SPLIT . "\r\n";
        $body .= $stringRequest;

        $message = new Swift_Message();
        $message->setSubject('New message sent by ' . $request->getRequestUri())
            ->setFrom('benjamin.calef@zepgram.com', $request->getHost())
            ->setTo('contact@ivc-digital.com')
            ->setBody($body);

        $mailer->send($message);
    }
}
