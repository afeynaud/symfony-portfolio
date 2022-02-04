<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CodeLanguage;
use App\Repository\CategoryRepository;
use App\Repository\CodeLanguageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProjectFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Rechercher un projet',
                ],
                'label' => false,
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => false,
                'placeholder' => 'Choisissez une catégorie',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'query_builder' => function (CategoryRepository $ppr) {
                    return $ppr ->createQueryBuilder('p')->orderBy('p.name', 'ASC');
                }
            ])
            ->add('codeLanguage', EntityType::class, [
                'class' => CodeLanguage::class,
                'choice_label' => 'name',
                'label' => false,
                'placeholder' => 'Choisissez un ou plusieurs langages informatiques',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'query_builder' => function (CodeLanguageRepository $ppr) {
                    return $ppr ->createQueryBuilder('p')->orderBy('p.name', 'ASC');
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}