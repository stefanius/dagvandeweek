<?php

namespace Stef\ContactFormBundle\Manager;

use Doctrine\Entity;
use Stef\ContactFormBundle\Entity\FormDefinition;
use Stef\SimpleCmsBundle\Manager\AbstractObjectManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class FormDefinitionManager extends AbstractObjectManager {

    protected $repoName = 'StefContactFormBundle:FormDefinition';

    /**
     * @param ParameterBag $data
     *
     * @return Entity
     */
    public function create(ParameterBag $data)
    {
        $formDefinition = new FormDefinition();

        $formDefinition->setFormFields($data->get('form_fields'));
        $formDefinition->setFormName($data->get('form_name'));
        $formDefinition->setSanitizedFormName($data->get('form_fields'));
        $formDefinition->setCreated($data->get('created'));
        $formDefinition->setModified($data->get('modified'));

        return $formDefinition;
    }
}