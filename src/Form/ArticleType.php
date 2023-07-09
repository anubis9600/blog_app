<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' =>[
                    'placeholder'=>"Titre de l'article",
                    "class" => "flex-1"
                ],
                "row_attr" => [
                "class" => "form-group flex"
                ],
                "required" => true
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' =>[
                    'placeholder'=>"Le contenu de l'article",
                    "class" => "flex-1",
                    'rows' => 10
                ],
                "row_attr" => [
                "class" => "form-group flex"
                ],
                "required" => false
            ])
            ->add('imageFile', FileType::class, [
                'label' => false,
                'attr' =>[
                    "class" => "flex-1"
                ],
                "row_attr" => [
                "class" => "form-group flex"
                ],
                "required" => false
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => false,
                'by_reference' => false,
                'attr' =>[
                    "class" => "flex-1 choices_categories"
                ],
                "row_attr" => [
                "class" => "form-group flex"
                ],
                "required" => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
