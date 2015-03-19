<?php

namespace Stef\ContactFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormDefinition
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FormDefinition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="formName", type="string", length=255)
     */
    private $formName;

    /**
     * @var string
     *
     * @ORM\Column(name="sanitizedFormName", type="string", length=255)
     */
    private $sanitizedFormName;

    /**
     * @var array
     *
     * @ORM\Column(name="formFields", type="json_array")
     */
    private $formFields;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    private $modified;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set formName
     *
     * @param string $formName
     * @return FormDefinition
     */
    public function setFormName($formName)
    {
        $this->formName = $formName;

        return $this;
    }

    /**
     * Get formName
     *
     * @return string 
     */
    public function getFormName()
    {
        return $this->formName;
    }

    /**
     * Set sanitizedFormName
     *
     * @param string $sanitizedFormName
     * @return FormDefinition
     */
    public function setSanitizedFormName($sanitizedFormName)
    {
        $this->sanitizedFormName = $sanitizedFormName;

        return $this;
    }

    /**
     * Get sanitizedFormName
     *
     * @return string 
     */
    public function getSanitizedFormName()
    {
        return $this->sanitizedFormName;
    }

    /**
     * Set formFields
     *
     * @param array $formFields
     * @return FormDefinition
     */
    public function setFormFields($formFields)
    {
        $this->formFields = $formFields;

        return $this;
    }

    /**
     * Get formFields
     *
     * @return array 
     */
    public function getFormFields()
    {
        return $this->formFields;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return FormData
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return FormData
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }
}
