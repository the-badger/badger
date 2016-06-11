<?php

namespace Badger\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
