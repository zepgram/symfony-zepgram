<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            '_locale' => $request->getLocale()
        ]);
    }
}
