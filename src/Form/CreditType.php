<?php

namespace App\Form;

use App\Entity\Credit;
use App\Entity\Customer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('montant')
            ->add('customer', EntityType::class, [
                'label_format' => 'Client',
                'required' => true,
                'class' => Customer::class,
                'placeholder' => 'Choisir un client',
                'choice_label' => function(Customer $customer) {
                    return $customer->getId() .' => '. $customer->getName();
                }
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
