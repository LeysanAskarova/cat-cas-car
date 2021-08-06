<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class ArticleFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Article|null $article */
        $article = $options['data'] ?? null;

        $cannotEditArticle = $article && $article->getId() && $article->isPublished();

        $imageConstraints = [
            new Image([
                'maxSize' => '1M'
            ]),
        ];

        if(!$article || !$article->getImageFilename()) {
            $imageConstraints[] = new NotNull([
                'message' => 'Не выбрано изображение статьи'
            ]);
        }
        $builder
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => $imageConstraints
            ])
            ->add('title', TextType::class, [
                'label'=>'Укажите название статьи',
                'help'=>'Не используйте специальные символы',
                'required'=>false
            ])
            ->add('body', TextareaType::class, [
                'label'=>'Укажите описание статьи',
                'rows'=>15
            ])
            ->add('author', EntityType::class, [
                'class'=> User::class,
                'choice_label'=>function(User $user) {
                    return sprintf('%s (id: %d)', $user->getFirstname(), $user->getId());
                },
                'placeholder'=>'Выберите автора статьи',
                'choices'=>$this->userRepository->findAllSortedByName(),
                'invalid_message'=>'такого автора не существует',
                'disabled'=> $cannotEditArticle
            ])
        ;

        if($options['enabled_published_at'] == true) {
            $builder->add('publishedAt', null, [
                'widget'=>'single_text'
            ]);
        }
        
        $builder->get('body')
                ->addModelTransformer(new CallbackTransformer(
                    function($bodyFromDatabase) {
                        return str_replace('**собака**', 'собака', $bodyFromDatabase);
                    },
                    function($bodyFromInput) {
                        return str_replace('собака', '**собака**', $bodyFromInput);
                    }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'enabled_published_at' =>false, 
        ]);
    }
}
