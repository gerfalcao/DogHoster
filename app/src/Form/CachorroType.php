<?php

namespace App\Form;

use App\Repository\DonoRepository;
use App\Entity\Cachorro;
use App\Entity\Dono;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Validator\Constraints\File;

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
                ]])
            ->add('photo', FileType::class, [
                'label' => 'Foto',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '102400k',
                         'mimeTypesMessage' => 'Favor subir um arquivo PNG ou JPG válido.',
                    ])
                ],
            ])
            ->add('dono', EntityType::class, [
                'class' => Dono::class,
                'attr' => ['class' => 'select2']
            ])
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
