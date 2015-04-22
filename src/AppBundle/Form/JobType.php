<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('companyName', 'text', array(
                    'label' => 'Nazwa Firmy',
                    'attr' => array(
                        'class' => 'form-control'
            )))
                ->add('type', 'choice', array(
                    'choices' => array(
                        '1' => 'Peły etat',
                        '2' => 'Niepełny etat',
                        '3' => 'Freelance'),
                    'label' => 'Rodzaj pracy',
                    'placeholder' => 'Wybierz opcje',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('logo', 'url', array(
                    'label' => 'Adres logo',
                    'attr' => array(
                        'class' => 'form-control'
            )))
                ->add('url', 'url', array(
                    'label' => 'Adres www',
                    'attr' => array(
                        'class' => 'form-control'
            )))
                ->add('position', 'text', array(
                    'label' => 'Stanowisko',
                    'attr' => array(
                        'class' => 'form-control'
            )))
                ->add('location', 'text', array(
                    'label' => 'Lokalizacja',
                    'attr' => array(
                        'class' => 'form-control'
            )))
                ->add('description', 'textarea', array(
                    'label' => 'Opis',
                    'attr' => array(
                        'class' => 'form-control'
            )))
                ->add('howToApply', 'choice', array(
                    'choices' => array(
                        '1' => 'Prześlij CV przez e-mail',
                        '2' => 'Zadzwoń do nas',
                        '3' => 'Przyjdź do nas'),
                    'label' => 'Jak aplikować',
                    'placeholder' => 'Wybierz opcje',
                    'attr' => array(
                        'class' => 'form-control'
            )))
                ->add('category', 'entity', array(
                    'class' => 'AppBundle:Category',
                    'property' => 'name',
                    'label' => 'Kategoria',
                    'attr' => array(
                        'class' => 'form-control'
            )))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Job'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_job';
    }

}
