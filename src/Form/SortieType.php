<?php

namespace App\Form;

use App\Entity\Sortie;
use phpDocumentor\Reflection\PseudoTypes\NumericString;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('dateHeureDebut', DateTimeType::class)
            ->add('dateLimiteInscription', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('nbInscriptionsMax')
            ->add('infosSortie', TextareaType::class)
            ->add('duree')//,TextType::class)  /// TODO AUCUNE SOLUTION > REFAIRE L'ENTITE ?
            ->add('lieu')
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
