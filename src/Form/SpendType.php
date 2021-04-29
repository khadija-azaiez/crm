<?php

namespace App\Form;

use App\Entity\Spend;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class)
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('montant')
            ->add('supplier', EntityType::class, [
                'required' => false,
                'class' => Supplier::class,
                'placeholder' => 'Choisir un fournisseur',
                'choice_label' => function (Supplier $supplier) {
                    return $supplier->getId() . ' => ' . $supplier->getName();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spend::class,
        ]);
    }
}
