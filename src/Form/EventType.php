<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => 'Nom'])
            ->add('price', MoneyType::class, ['label' => 'Prix'])
            ->add('startAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Début',
            ])
            ->add('endAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Fin',
            ])
            
            // ->add('poster')
            ->add('place', null, [
                'choice_label' => 'city',
                'label' => 'Ville',
            ])
            ->add('categories', null, [
                'choice_label' => 'name',
                'expanded' => true,
                'label' => 'Catégories',
            ])
            ->add('posterFile', FileType::class, [
                'label' => 'Image'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
