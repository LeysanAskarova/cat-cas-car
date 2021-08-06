<?php

namespace App\DataFixtures;

use App\Service\FileUploader;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

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
    /**
     * @var FileUploader
     */
    private $articleFileUploader;

    public function __construct(FileUploader $articleFileUploader)
    {
        $this->articleFileUploader = $articleFileUploader;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article) use ($manager){
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setBody('Lorem ipsum **красная точка** dolor sit amet, consectetur adipiscing elit, sed
                do eiusmod tempor incididunt [Сметанка](/) ut labore et dolore magna aliqua.
' . $this->faker->paragraphs($this->faker->numberBetween(2, 5), true));

            $fileName = $this->faker->randomElement(self::$articleImages);

            $tmpFileName = sys_get_temp_dir() . '/' .$fileName;
            (new Filesystem())->copy(dirname(dirname(__DIR__)) . '/public/images/' . $fileName, $tmpFileName, true);

            $article
                ->setAuthor($this->getRandomReference(User::class))
                ->setImageFilename($this->articleFileUploader
                    ->uploadFile(new File($tmpFileName)))
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
