<?php

namespace Badger\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class QuestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'textarea')
            ->add('reward', 'integer')
            ->add('startDate', 'date', ['widget' => 'single_text', 'format' => 'yyyy/MM/dd'])
            ->add('endDate', 'date', ['widget' => 'single_text', 'format' => 'yyyy/MM/dd'])
            ->add('tags', 'entity', [
                'label'    => 'Tagged in',
                'multiple' => true,
                'property' => 'name',
                'required' => false,
                'class'    => 'Badger\TagBundle\Entity\Tag'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Badger\GameBundle\Entity\Quest'
        ]);
    }
}
