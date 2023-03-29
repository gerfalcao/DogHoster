<?php

namespace App\Form;

use App\Entity\Servicos;
use Faker\Core\Number;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => false,
            ])
            ->add('preco', NumberType::class, [
                'label' => false,
            ])
            ->add('quantidade', NumberType::class, [
                'data' => '1'
            ])
            // ->add('hospedagem')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Servicos::class,
        ]);
    }
}
