<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Category;
use App\Entity\CodeLanguage;
use App\Repository\CategoryRepository;
use App\Repository\CodeLanguageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre du projet',
                ],
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un titre de projet',
                    ])
                ]
            ])
            ->add('description', TextareaType::class , [
                'attr' => [
                    'placeholder' => 'Description du projet',
                ],
                'label' => false,
            ])
            ->add('showcaseImage', TextType::class, [
                'attr' => [
                    'placeholder' => 'Lien vers une image du projet',
                ],
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un lien vers une image',
                    ])
                ]
            ])
            ->add('projectDate', DateType::class, [
                'required' => false,
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    ],
            ])
            ->add('applicationUrl', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien vers l\'application',
                ],
            ])
            ->add('githubUrl', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien vers le dépôt GitHub',
                ],
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
