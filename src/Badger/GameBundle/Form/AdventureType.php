<?php

namespace Badger\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdventureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'textarea', [
                'attr' => [
                    'rows' => 3
                ]
            ])
            ->add('rewardPoint')
            ->add('isStepLinked')
            ->add('badge', 'entity', [
                'class'      => 'GameBundle:Badge',
                'property'   => 'title',
                'empty_data' => '',
                'required'   => false
            ])
            ->add('steps', 'collection', [
                'entry_type'   => new StepType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'        => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Badger\GameBundle\Entity\Adventure'
        ]);
    }

    public function getName()
    {
        return 'adventure';
    }
}
