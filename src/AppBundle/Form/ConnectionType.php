<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConnectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $notBlank = [ "constraints" => new NotBlank() ];

        $builder
            ->add('uid', 'text')
            ->add('service', 'text')
            ->add('cuid', 'text', $notBlank);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'AppBundle\Entity\Connection',
            'intention'          => 'connection',
            'translation_domain' => 'AppBundle',
            'csrf_protection'    => false
        ));

    }

    public function getName()
    {
        return 'connection';
    }
}
