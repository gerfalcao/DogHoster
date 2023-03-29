<?php

namespace App\Form;

use App\Entity\Dono;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Maria Aparecida'),
                'label' => false,
            ])
            ->add('email', EmailType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'seunome@seuemail.com'),
                'label' => false,  
            ])
            ->add('telefone', TextType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => '(99) 9999-9999'),
                'label' => false,
            ])
        ;

        // $builder
        // ->add('cachorro', CollectionType::class, [
        //     'entry_type' => CachorroType::class,
        //     'entry_options' => ['label' => false],
        //     'allow_add' => true,
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dono::class,
        ]);
    }
}
