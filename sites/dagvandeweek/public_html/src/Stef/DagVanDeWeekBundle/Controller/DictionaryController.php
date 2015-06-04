<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\SimpleCmsBundle\Entity\Page;

class DictionaryController extends BaseController
{
    /**
     * Show a dictionary entry.
     */
    public function show($slug)
    {
        $dictionary = $this->getDictionaryManager()->read($slug);

        if (!$dictionary) {
            throw $this->createNotFoundException('Unable to find News post.');
        }

        return $this->render('StefBierInDeKlokBundle:Dictionary:show.html.twig', [
            'page' => $dictionary,
        ]);
    }

    /**
     * Show a dictionary entry.
     */
    public function indexAction($letter = null)
    {
        $page = new Page();

        if ($letter === null) {
            $wordlist = [];
            $page->setTitle('Bier van A tot Z');
            $page->setDescription('Bier bestaat uit meer van vocht, alcohol en een schuimkraag. Wij leggen hier van A tot Z uit wat bier is, waar het uit bestaat en wat je ermee kan doen!');
        } elseif (is_string($letter) && strlen($letter) === 1 && !is_numeric($letter)) {
            $wordlist = $this->getDictionaryManager()->simpleQueryBuilding([
                'where' => 'e.firstLetter like :letter',
                'param' => ['letter', $letter],
            ]);

            $page->setTitle('Begrippenlijst - ' . ucfirst($letter));
            $page->setDescription(ucfirst($letter) . ' is een letter vol met Bier geheimen! Wij gever hier ' . count($wordlist) . ' geheimen prijs met de letter ' . ucfirst($letter) . '! Bekijk ook de rest van ons Bier alfabet!');
        } else {
            return $this->show($letter);
        }

        return $this->render('StefBierInDeKlokBundle:Dictionary:index.html.twig', [
            'letter' => $letter,
            'wordlist' => $wordlist,
            'page' => $page,
        ]);
    }
}
