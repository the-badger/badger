<?php

namespace Badger\Bundle\GameBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author  Marie Bochu <marie.bochu@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class AdventureStepType extends AbstractType
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
            ->add('position')
            ->add('rewardPoint', null, [
                'label' => 'game.step.form.reward_point'
            ])
            ->add('badge', EntityType::class, [
                'class'        => 'GameBundle:Badge',
                'choice_label' => 'title',
                'empty_data'   => '',
                'required'     => false,
                'label'        => 'game.step.form.badge'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Badger\Bundle\GameBundle\Entity\AdventureStep'
        ]);
    }
}
