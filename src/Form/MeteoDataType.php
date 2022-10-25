<?php

namespace App\Form;

use App\Entity\MeteoData;
use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MeteoDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('highestTemperature')
            ->add('lowestTemperature')
            ->add('averageWindSpeed')
            ->add('overcast', ChoiceType::class, [
                'choices' => [
                    '0/8' => '0/8',
                    '1/8' => '1/8',
                    '2/8' => '2/8',
                    '3/8' => '3/8',
                    '4/8' => '4/8',
                    '5/8' => '5/8',
                    '6/8' => '6/8',
                    '7/8' => '7/8',
                    '8/8' => '8/8',
                ],
            ])
            ->add('precipitationKind', ChoiceType::class, [
                'choices' => [
                    'none' => 'none',
                    'rain' => 'rain',
                    'snow' => 'snow',
                    'sleet' => 'sleet',
                    'hail' => 'hail',
                ],
            ])
            ->add('precipitationIntensity')
            ->add('humidity', NumberType::class, [
                'scale' => 3,
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeteoData::class,
        ]);
    }
}
