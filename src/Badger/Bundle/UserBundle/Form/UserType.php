<?php

namespace Badger\Bundle\UserBundle\Form;

use Badger\Bundle\GameBundle\Entity\Tag;
use Badger\Bundle\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('tags', EntityType::class, [
                'label' => 'Tagged in',
                'multiple' => true,
                'required' => false,
                'class' => Tag::class
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
