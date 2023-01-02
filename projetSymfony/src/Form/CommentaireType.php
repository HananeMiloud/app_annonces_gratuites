<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            
            ->add('content',TextareaType::class,[
                'label'=>'message',
                'attr' => [ 
                    'class'=>'form-control',
                    'style' => ' height:300px; '
            ]
            ])
            ->add('parentid',HiddenType::class,[ 
                'mapped' => false
            ])
            ->add('submit',SubmitType::class, [
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
            'data_class' => Commentaire::class,
        ]);
    }
}
