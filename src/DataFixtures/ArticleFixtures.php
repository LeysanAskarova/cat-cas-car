<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Title 1',
        'Title 2',
        'Title 3',
        'Title 4',
    ];

    private static $articleImages = [
        'car1.jpg',
        'car2.jpg',
        'car3.jpeg',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article) use ($manager){
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setBody('Lorem ipsum **красная точка** dolor sit amet, consectetur adipiscing elit, sed
                do eiusmod tempor incididunt [Сметанка](/) ut labore et dolore magna aliqua.
' . $this->faker->paragraphs($this->faker->numberBetween(2, 5), true));
            
            $article
                ->setAuthor($this->getRandomReference(User::class))
                ->setImageFilename($this->faker->randomElement(self::$articleImages))
                ->setLikeCount($this->faker->numberBetween(0,10));

            if($this->faker->boolean(60)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $tags = [];
            for($i = 0; $i < $this->faker->numberBetween(0,5); $i++) {
                $tags[] = $this->getRandomReference(Tag::class);
            }
            
            foreach($tags as $tag) {
                $article->addTag($tag);
            }
        });
    }

    public function getDependencies ()
    {
        return [
            TagFixtures::class,
            UserFixtures::class,
        ];
    }
}
