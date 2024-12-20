<?php

namespace App\Form;

use App\Entity\Alergeno;
use App\Entity\Elemento;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('precio', MoneyType::Class, [
                'required' => false
            ])
            ->add('descripcion')
            ->add('alergenos', EntityType::class, [
                'class' => Alergeno::class,
                'choice_label' => 'nombre',
                'label' => 'Alérgenos que tiene este artículo',
                'expanded' => true,
                'multiple' => true

            ])
        ->add('save', SubmitType::class, [
            'label' => ' ',
        ])
        ->add('saveAndAdd', SubmitType::class, [
            'label' => ' ',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Elemento::class,
        ]);
    }
}
