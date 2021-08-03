<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        $builder
            ->add('title', TextType::class, [
                'label'=>'Укажите название статьи',
                'help'=>'Не используйте специальные символы',
                'required'=>false
            ])
            ->add('body', TextType::class, [
                'label'=>'Укажите описание статьи'
            ])
            ->add('publishedAt', null, [
                'widget'=>'single_text'
            ])
            ->add('author', EntityType::class, [
                'class'=> User::class,
                'choice_label'=>function(User $user) {
                    return sprintf('%s (id: %d)', $user->getFirstname(), $user->getId());
                },
                'placeholder'=>'Выберите автора статьи',
                'choices'=>$this->userRepository->findAllSortedByName(),
                'invalid_message'=>'такого автора не существует'
            ])
        ;
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
        ]);
    }
}
