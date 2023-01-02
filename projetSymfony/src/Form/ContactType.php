<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom',TextType::class,[
            "label"=>false
        ])
        ->add('prenom',TextType::class,[
            "label"=>false
        ])
        ->add('email', EmailType::class,[
            "label"=>false
        ])
       
        ->add('message',TextareaType::class,[
            "label"=>false
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Envoyer",
            'attr' => [
                'class'=>'btn  text-white mt-2  ',
                'style' => 'width:200px; height:50px; border-radius: 0px;margin:5px;'
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
