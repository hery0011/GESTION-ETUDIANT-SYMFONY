<?php

namespace App\Form;

use App\Entity\Students;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=>'nom',
                'attr'=> ['class'=>'form-control', 'placeholder'=>'votre nom']
                ])
            ->add('prenom', TextType::class, [
                'label'=>'prenom',
                'attr'=> ['class'=>'form-control', 'placeholder'=>'votre prenom']
                ])
            ->add('mail', TextType::class, [
                'label'=>'mail',
                'attr'=> ['class'=>'form-control', 'placeholder'=>'votre mail']
                ])
            ->add('password', TextType::class, [
                'label'=>'password',
                'attr'=> ['class'=>'form-control', 'placeholder'=>'votre password']
                ])
            ->add('photo', FileType::class, [
                'label'=>'photo',
                'attr'=> ['class'=>'form-control', 'placeholder'=>'votre photo']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
