<?php

namespace Badger\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('github_id')
//            ->add('github_access_token')
//            ->add('google_id')
//            ->add('google_access_token')
//            ->add('profilePicture')
            ->add('username')
            ->add('tags', 'entity', [
                'label' => 'Tagged in',
                'multiple' => true,
                'property' => 'name',
                'required' => false,
                'class' => 'Badger\TagBundle\Entity\Tag'
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Badger\UserBundle\Entity\User'
        ]);
    }
}
