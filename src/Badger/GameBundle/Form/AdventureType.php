<?php

namespace Badger\GameBundle\Form;

use Badger\TagBundle\Form\TagType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author  Marie Bochu <marie.bochu@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 3
                ]
            ])
            ->add('rewardPoint', null, [
                'label' => 'game.adventure.form.reward_point'
            ])
            ->add('isStepLinked')
            ->add('badge', EntityType::class, [
                'class'        => 'GameBundle:Badge',
                'choice_label' => 'title',
                'empty_data'   => '',
                'required'     => false,
                'label'        => 'game.adventure.form.badge'
            ])
            ->add('steps', CollectionType::class, [
                'entry_type'   => AdventureStepType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'        => false
            ])
            ->add('tags', EntityType::class, [
                'label'        => 'Tagged in',
                'multiple'     => true,
                'choice_label' => 'name',
                'required'     => false,
                'class'        => 'Badger\TagBundle\Entity\Tag'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Badger\GameBundle\Entity\Adventure'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'adventure';
    }
}
