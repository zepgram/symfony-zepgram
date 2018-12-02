<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;
use App\Entity\ContactHydrator;
use App\Mailer\SendEntityMail;
use Swift_Mailer;

class ContactController extends AbstractController
{
    /**
     * @var SendEntityMail
     */
    protected $sendEntityEmail;

    /**
     * ContactController constructor.
     *
     * @param SendEntityMail $entityMail
     */
    public function __construct(SendEntityMail $entityMail)
    {
        $this->sendEntityEmail = $entityMail;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, Swift_Mailer $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $response = $this->redirectToRoute('app_index_index');

        if (!$request->isXmlHttpRequest() && !$form->isSubmitted()) {
            return $response;
        }

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $contact->setCreatedAt(new \DateTime('now'));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();

                $hydrator = new ContactHydrator();
                $contactData = $hydrator->extract($contact);
                $this->sendEntityEmail->send($contactData, $mailer);

                $response = new JsonResponse(['status' => 'success'], 200);
            }

        } catch (\Exception $e) {
            $response = new JsonResponse(['status' => 'error', 'exception' => $e], 200);
        }

        return $response;
    }


}
