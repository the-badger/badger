<?php

namespace Badger\Bundle\GameBundle\Form;

use Badger\Bundle\GameBundle\Entity\Badge;
use Badger\Bundle\GameBundle\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BadgeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('tags', EntityType::class, [
                'label' => 'Tagged in',
                'multiple' => true,
                'choice_label' => 'name',
                'required' => false,
                'class' => Tag::class
            ])
            ->add('imagePath')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Badge::class
        ]);
    }
}
