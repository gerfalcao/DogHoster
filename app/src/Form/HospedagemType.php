<?php

namespace App\Form;

use App\Entity\Hospedagem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospedagemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('data_inicio')
            ->add('data_fim')
            ->add('temBanho')
            ->add('temAdestramento')
            ->add('Cachorro')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hospedagem::class,
        ]);
    }
}
