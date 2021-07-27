<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function(Comment $comment) {
            $comment->setAuthorName($this->faker->name)
            ->setContent($this->faker->paragraph)
            ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'))
            ->setArticle($this->getRandomReference(Article::class));

            if($this->faker->boolean(50)) {
                $comment->setDeletedAt($this->faker->dateTimeThisMonth);
            }
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
        ];
    }
}
