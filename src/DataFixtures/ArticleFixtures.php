<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends BaseFixtures
{
    private static $articleTitles = [
        'Title 1',
        'Title 2',
        'Title 3',
        'Title 4',
    ];

    private static $articleAuthors = [
        'Author 1',
        'Author 2',
        'Author 3',
        'Author 4',
    ];

    private static $articleImages = [
        'car1.jpg',
        'car2.jpg',
        'car3.jpeg',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article) {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setBody('Lorem ipsum **красная точка** dolor sit amet, consectetur adipiscing elit, sed
                do eiusmod tempor incididunt [Сметанка](/) ut labore et dolore magna aliqua.
' . $this->faker->paragraphs($this->faker->numberBetween(2, 5), true));
            
            $article
                ->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setImageFilename($this->faker->randomElement(self::$articleImages))
                ->setLikeCount($this->faker->numberBetween(0,10));
    
            if($this->faker->boolean(60)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }
        });
    }
}
