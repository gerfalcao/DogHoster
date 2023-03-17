<?php

namespace App\Form;

use App\Repository\DonoRepository;
use App\Entity\Cachorro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CachorroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome')
            ->add('porte')
            ->add('agressividade')
            ->add('dono')
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cachorro::class,
        ]);
    }
}
