<?php

namespace App\Form;

use App\Entity\Intervention;
use App\Entity\Problem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('officeNumber')
            ->add('pc')
            ->add('description')
            ->add('problem', EntityType::class, [
                'class' => Problem::class,
                'choice_label' => 'type',
                'label' => 'probleme',
                'expanded'=> true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
            'csrf_protection' => false,
            'disabled' => true
        ]);
    }
}
