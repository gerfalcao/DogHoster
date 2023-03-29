<?php

namespace App\Form;

use App\Entity\Cachorro;
use App\Entity\Hospedagem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospedagemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('data_inicio', DateTimeType::class, [
            //     'widget' => 'single_text',
            // ])
            // ->add('data_fim', DateTimeType::class, [
            //     'required' => false,
            //     'widget' => 'single_text',
            //     'label' => 'Data Fim',
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'by_reference' => true
            // ])
            
            ->add('Cachorro', EntityType::class, [
                'class' => Cachorro::class,
                'attr' => ['class' => 'select2'],
                'label' => 'Cachorro / Dono: '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hospedagem::class,
        ]);
    }
}
