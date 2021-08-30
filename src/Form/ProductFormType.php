<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name' )
            ->add('Quantity')
            ->add('ProductDesc')
            ->add('Image', FileType::class,
            [
                'data_class' => null,
                'required' => is_null($builder->getData()->getImage())
            ])
            ->add('Price')
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'multiple' => false,
                'choice_label' => 'catName',
                'expanded' => false])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
