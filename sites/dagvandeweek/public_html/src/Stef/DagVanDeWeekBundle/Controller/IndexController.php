<?php

namespace Stef\BierInDeKlokBundle\Controller;

use Stef\SimpleCmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $page = new Page();
        $page->setDescription('Staat de 4 in de klok? Dan staat er Bier in de klok. Elk moment van de dag de vier willen checken? Dat kan bij BierInDeKlok.nl!');
        $page->setTitle('Bier in de Klok?!');

        return $this->render('StefBierInDeKlokBundle:Default:index.html.twig', [
            'page' => $page
        ]);
    }
}
