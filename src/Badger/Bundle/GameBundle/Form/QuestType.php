<?php

namespace Badger\Bundle\GameBundle\Form;

use Badger\Bundle\GameBundle\Entity\Quest;
use Badger\Bundle\GameBundle\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('description', TextareaType::class)
            ->add('reward', IntegerType::class)
            ->add('startDate', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy/MM/dd'])
            ->add('endDate', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy/MM/dd'])
            ->add('tags', EntityType::class, [
                'label'    => 'Tagged in',
                'multiple' => true,
                'required' => false,
                'class'    => Tag::class
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quest::class
        ]);
    }
}
