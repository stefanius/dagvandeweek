<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\DagVanDeWeekBundle\Entity\Contact;
use Stef\DagVanDeWeekBundle\Form\ContactType;
use Stef\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $page = new Page();
        $page->setDescription('Het heden en verleden komen samen op DagVanDeWeek! Elke dag een nieuwe dag. Bekijk onze kalenders en laat het verleden naar vandaag komen!');
        $page->setTitle('Alle dagen van de week welkom bij DagVanDeWeek.nl');

        return $this->render('StefDagVanDeWeekBundle:Default:index.html.twig', [
            'page' => $page,
        ]);
    }

    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $contact = new Contact();
                $contact->setEmail($form->get('email')->getData());
                $contact->setName($form->get('name')->getData());
                $contact->setReason($form->get('reason')->getData());
                $contact->setPhone($form->get('phone')->getData());
                $contact->setIp($request->getClientIp());
                $contact->setSummary($form->get('summary')->getData());
                $contact->setModified(new \DateTime());
                $contact->setCreated(new \DateTime());

                $manager = $this->getContactManager();
                $manager->persistAndFlush($contact);

                return $this->redirect($this->generateUrl('stef_dag_van_de_week_contact'));
            }
        }

        $page = new Page();
        $page->setDescription('Neem vrijblijvend contact op met de redactie achter DagVanDeWeek.nl!');
        $page->setTitle('Contact');

        return $this->render('StefDagVanDeWeekBundle:Default:contact.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
}
