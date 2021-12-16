<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('paragon')
            ->add('birth')
            ->add('phone')
            ->add('product')
            ->add('legal_a')
            ->add('legal_b')
            ->add('legal_c')
            ->add('legal_d')
            ->add('img_receipt')
            ->add('shop')
            ->add('category')
            ->add('from_where')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
