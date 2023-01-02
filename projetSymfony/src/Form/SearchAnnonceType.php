<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots', SearchType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width:400px; height:50px; margin-bottom: .5rem; margin-right: .5rem;',
                    'placeholder' => 'Entrez un ou plusieurs mots-clés'
                ],
                'required' => false
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'label' => false,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width:400px; height:50px ;margin-bottom: .5rem; margin-right: .5rem; margin-bottom: 0',
                    'placeholder' => 'choisi une catégorie'
                ],
                'required' => false
            ])
            
            ->add('Rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn pull-right ',
                    'style' => 'width:200px; height:50px; border-radius: 0px;margin:5px;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}