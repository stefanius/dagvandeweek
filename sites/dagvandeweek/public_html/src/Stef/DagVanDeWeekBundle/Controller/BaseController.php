<?php

namespace Stef\BierInDeKlokBundle\Controller;

use Ivory\GoogleMap\Map;
use Stef\SimpleCmsBundle\KeyValueParser\Parser;
use Stef\SimpleCmsBundle\Manager\DictionaryManager;
use Stef\SimpleCmsBundle\Manager\NewsManager;
use Stef\SimpleCmsBundle\Manager\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function getRepository($repository)
    {
        $em = $this->getEntityManager();

        return $em->getRepository($repository);
    }

    /**
     * @return DictionaryManager
     */
    protected function getDictionaryManager()
    {
        return $this->get('stef_simple_cms.dictionary_manager');
    }

    /**
     * @return PageManager
     */
    protected function getPageManager()
    {
        return $this->get('stef_simple_cms.page_manager');
    }

    /**
     * @return NewsManager
     */
    protected function getNewsManager()
    {
        return $this->get('stef_simple_cms.news_manager');
    }

    /**
     * @return Parser
     */
    protected function getKeyValueParser()
    {
        return $this->get('stef_simple_cms.key_value_parser');
    }

    /**
     * @return Map
     */
    protected function getIvoryGoogleMap()
    {
        return $this->get('ivory_google_map.map');
    }
}