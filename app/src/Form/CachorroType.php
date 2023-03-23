<?php

namespace App\Form;

use App\Repository\DonoRepository;
use App\Entity\Cachorro;
use App\Entity\Dono;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;


class CachorroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome')
            ->add('porte')
            ->add('agressividade', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100
                ]]);
            // ->add('dono', EntityType::class, [
            //     'class' => Dono::class,
            //     'attr' => ['class' => 'select2']
            // ])
        // $builder 
        //         ->add('dono', EntityType::class, [
        //         'class' => Dono::class,
             
        //         'attr' => ['class' => 'select2']
        //     ]);
                           
         ;
      
    }

   
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cachorro::class,
        ]);
    }
}
