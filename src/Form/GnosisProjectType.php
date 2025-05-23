<?php

namespace App\Form;

use App\Entity\GnosisProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GnosisProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Description')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('finished_at', null, [
                'widget' => 'single_text',
            ])
            ->add('is_closed', ChoiceType::class, [
                'label' => 'Gnosis Project accessibility',
                'mapped' => true,
                'choices'  => [
                    'Closed' => 1,
                    'Open' => 0,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GnosisProject::class,
        ]);
    }
}
