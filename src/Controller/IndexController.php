<?php

namespace App\Controller;

use App\Form\ContactForm;
use Contentful\Delivery\Client\ClientInterface;
use Contentful\Delivery\Query;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, ClientInterface $client, MailerInterface $mailer): Response
    {
        $customers = $client->getEntries((new Query())->setContentType('customer'));
        $blogPosts = $client->getEntries((new Query())->setContentType('blogEntry')->setLimit(3));

        $formSuccess = false;
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $formSuccess = true;

            $email = (new TemplatedEmail())
                ->from(new Address('noreply@detra.cloud', 'Deter Consulting'))
                ->to($contact['email'])
                ->cc('info@deter-consulting.de')
                ->replyTo('info@deter-consulting.de')
                ->subject('Vielen Dank für deine Anfrage')
                ->htmlTemplate('mail/index.html.twig')
                ->textTemplate('mail/index.text.twig')
                ->context(['contact' => $contact]);

            $mailer->send($email);


            $form = $this->createForm(ContactForm::class);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            dump($form->getErrors());die();
        }



        return $this->render('index/index.html.twig', [
            'customers' => $customers,
            'blogPosts' => $blogPosts,
            'form' => $form->createView(),
            'formSuccess' => $formSuccess
        ]);
    }
}
