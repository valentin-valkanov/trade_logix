<?php

namespace App\Form;

use App\Entity\Position;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entryTime', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy.MM.dd HH:mm:ss',
                'html5' => false,
            ])
            ->add('position', TextType::class)
            ->add('symbol', TextType::class)
            ->add('type', TextType::class)
            ->add('volume', NumberType::class)
            ->add('entry', NumberType::class)
            ->add('stopLoss', NumberType::class)
            ->add('takeProfit', NumberType::class)
            ->add('exitTime', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy.MM.dd HH:mm:ss',
                'html5' => false,
            ])
            ->add('exit', NumberType::class)
            ->add('commission', NumberType::class)
            ->add('swap', NumberType::class)
            ->add('profit', NumberType::class)
            ->add('system', TextType::class)
            ->add('strategy', TextType::class)
            ->add('assetClass', TextType::class)
            ->add('grade', TextType::class)
            ->add('week', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Position::class,
        ]);
    }
}
