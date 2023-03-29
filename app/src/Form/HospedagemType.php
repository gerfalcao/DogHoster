<?php

namespace App\Form;

use App\Entity\Cachorro;
use App\Entity\Hospedagem;
use App\Repository\HospedagemRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospedagemType extends AbstractType
{
    private $hospedagemRepository;

    public function __construct(HospedagemRepository $hospedagemRepository)
    {
        $this->hospedagemRepository = $hospedagemRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        

        $builder
                    
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
