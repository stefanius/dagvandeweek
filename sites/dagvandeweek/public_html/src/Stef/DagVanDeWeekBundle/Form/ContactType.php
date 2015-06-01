<?php

namespace Stef\DagVanDeWeekBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Class ContactType
 *
 * This FormType is used to display a contact form on the webpage itself. Not to be confused with the CMS.
 *
 * @package Stef\DagVanDeWeekBundle\Form
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', 'choice', array(
                'choices' => array(
                    ''   => 'Maak een keuze',
                    'Tip voor de redactie' => 'Tip voor de redactie',
                    'Linkruil'   => 'Linkruil',
                    'Anders'   => 'Anders',
                ),
                'label' => 'Onderwerp',
            ))
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'Jouw naam',
                    'pattern'     => '.{2,}' //minlength
                ),
                'label' => 'Naam',
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'voorbeeld@domein.nl'
                ),
                'label' => 'Email',
            ))
            ->add('phone', 'text', array(
                'attr' => array(
                    'placeholder' => 'Je telefoonnummer',
                ),
                'label' => 'Telefoon',
            ))
            ->add('summary', 'textarea', array(
                'attr' => array(
                    'cols' => 90,
                    'rows' => 10,
                    'placeholder' => 'Schrijf hier nog iets dat je aan ons kwijt wilt'
                ),
                'label' => 'Bericht',
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'name' => array(
                new NotBlank(array('message' => 'Je naam is verplicht')),
                new Length(array('min' => 2))
            ),
            'email' => array(
                new NotBlank(array('message' => 'Je email is verplicht.')),
                new Email(array('message' => 'Email is onjuist'))
            ),
            'reason' => array(
                new NotBlank(array('message' => 'Het onderwerp is verplicht.')),
                new Length(array('min' => 3))
            ),
            'summary' => array(
                new NotBlank(array('message' => 'Geef een korte toelichting in het tekstvak.')),
                new Length(array('min' => 5))
            ),
            'phone' => array (),
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}