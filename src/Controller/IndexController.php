<?php

namespace App\Controller;

use App\Form\ContactForm;
use Contentful\Delivery\Client\ClientInterface;
use Contentful\Delivery\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, ClientInterface $client): Response
    {
        $query = new Query();

        $customers = $client->getEntries((new Query())->setContentType('customer'));
        $blogPosts = $client->getEntries((new Query())->setContentType('blogEntry')->setLimit(3));

        /**
        $customers = [];
        foreach ($c as $entry) {
            $customers[] = [
                'name' => $entry->getCustomerName(),
                'logo' => $entry->getLogo()?->getFile()?->getUrl()
            ];
        }
         **/

        $formSuccess = false;
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            //@Todo Send mail
            $formSuccess = true;

            $form = $this->createForm(ContactForm::class);
        }



        return $this->render('index/index.html.twig', [
            'customers' => $customers,
            'blogPosts' => $blogPosts,
            'form' => $form->createView(),
            'formSuccess' => $formSuccess
        ]);
    }
}
