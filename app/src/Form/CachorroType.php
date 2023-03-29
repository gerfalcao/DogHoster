<?php

namespace App\Form;

use App\Repository\DonoRepository;
use App\Entity\Cachorro;
use App\Entity\Dono;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Validator\Constraints\File;


class CachorroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        

        $builder
            ->add('nome', TypeTextType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Bruce'
                ),
                'label' => false,
            ])
            ->add('porte', ChoiceType::class, [
                'choices' => [
                    'Micro' => 1,
                    'Pequeno' => 2,
                    'Médio' => 3,
                    'Grande' => 4
                ],   
                'choice_label' => function ($value, $key, $index) {
                    switch ($value) {
                        case 1:
                            return 'Micro';
                        case 2:
                            return 'Pequeno';
                        case 3:
                            return 'Médio';
                        case 4:
                            return 'Grande';
                    }
                },
                'label' => false,
                'attr' => [
                'class' => 'form-select'
                ]
            ])
            
            ->add('agressividade', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100
                ],
                'label' => false
                ])
            ->add('photo', FileType::class, [
                'label' => false,
               
                

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
                'attr' => ['class' => 'select2'],
                'label' => false,
            ])
            // ->add('submit', SubmitType::class, [
            //     'label' => 'Cadastrar'
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
