<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie'
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'html5' => true,
                'widget' => 'single_text', ])
            ->add('dateLimiteInscription', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('nbInscriptionsMax')
            ->add('infosSortie', TextareaType::class)
            ->add('duree')

            //TODO check jointure form dans controller
//            ->add('ville', EntityType::class,[
//                'class' => Ville::class,
//                'choice_label' => 'nom',
//                'mapped' => false
//            ])
//            ->add('campus', EntityType::class,[
//                'class' => Campus::class,
//                'choice_label' => 'nom',
//            ])
            ->add('lieu',EntityType::class,[
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ])
//            ->add('Participant',EntityType::class,[
//                'class'=> Participant::class
//    ])
        ;

    }
    //TODO AJOUTER CHAMPS VILLES LONGITUDE LATITUDE

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
