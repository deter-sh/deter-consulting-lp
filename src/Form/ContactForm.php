<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', TextType::class, ['attr' => ['placeholder' => 'Firmenname'], 'required' => false])
            ->add('contactPerson', TextType::class, ['attr' => ['placeholder' => 'Ansprechpartner *'], 'required' => true])
            ->add('email', EmailType::class, ['attr' => ['placeholder' =>  'E-Mail *'], 'required' => true])
            ->add('phone', TextType::class, ['attr' => ['placeholder' => 'Telefonnummer'], 'required' => false])
            ->add('message', TextareaType::class, ['attr' => ['placeholder' => 'Deine Herausforderung / Anliegen', 'rows' => 10, 'class' => 'ignore-form-control'], 'required' => true])
            ->add('dsgvo', CheckboxType::class, ['label' => 'Ich habe die Datenschutzerklärung gelesen und akzeptiere sie.', 'required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
