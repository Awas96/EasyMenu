<?php

namespace App\Form;

use App\Entity\Seccion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
            ])
            ->add('icono', ChoiceType::class, [
                'choices' => [
                    'Cuchillo y tenedor' => 'fa-utensils',
                    'Cuchara' => 'fa-utensil-spoon',
                    'Hamburguesa' => 'fa-hamburger',
                    'Trozo de Pizza' => 'fa-pizza-slice',
                    'Huevo' => 'fa-egg',
                    'Cuña de queso' => 'fa-cheese',
                    'Pan' => 'fa-bread-slice',
                    'Bacon' => 'fa-bacon',
                    'Muslo de pollo' => 'fa-drumstick-bite',
                    'Hueso' => 'fa-bone',
                    'Pimiento' => 'fa-pepper-hot',
                    'Torta' => 'fa-stroopwafel',
                    'Cono de helado' => 'fa-ice-cream',
                    'Pez' => 'fa-fish',
                    'Galleta' => 'fa-cookie',
                    'Piruleta' => 'fa-candy-cane',
                    'Zanahoria' => 'fa-carrot',
                    'Planta' => 'fa-seedling',
                    'Manzana' => 'fa-apple-alt',
                    'Limón' => 'fa-lemon',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seccion::class,
        ]);
    }
}
