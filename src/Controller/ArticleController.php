<?php
namespace App\Controller;

//use App\Service\MarkdownParser;
use App\Service\SlackClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use Demontpx\ParsedownBundle\Parsedown;
//use Symfony\Component\Cache\Adapter\AdapterInterface;
//use Symfony\Component\HttpFoundation\Response;
//use Twig\Environment;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(
        //bool $debug
    )
    {
        //dd($this->getParameter('app.support_email')); get parameter from .env and services.yaml
        //dd($debug);
        return $this->render('articles/homepage.html.twig');
    }

    /**
     * @Route("/articles/{slug}" , name="app_article_show")
     */
    public function show($slug, //Parsedown $parsedown, AdapterInterface $cache, deleted when creted markdown service
        //MarkdownParser $markdownParser,
        SlackClient $slackClient
    ) {
        if ($slug == 'slack') 
        {
            $slackClient->send('Привет это важное уведомление');
        }

        
        $comments = [
            'First comment',
            'Second comment',
            'Third comment',
        ];
        $articlecontent = <<< EOF
            Lorem ipsum **красная точка** dolor sit amet, consectetur adipiscing elit, sed
            do eiusmod tempor incididunt [Сметанка](/) ut labore et dolore magna aliqua.
            Purus viverra accumsan in nisl. Diam vulputate ut pharetra sit amet aliquam. Faucibus a
            pellentesque sit amet porttitor eget dolor morbi non. Est ultricies integer quis auctor
            elit sed. Tristique nulla aliquet enim tortor at. Tristique et egestas quis ipsum. Consequat semper viverra nam
            libero. Lectus quam id leo in vitae turpis. In eu mi bibendum neque egestas congue
            quisque egestas diam. **Красная точка** blandit turpis cursus in hac habitasse platea dictumst quisque.

            Ullamcorper malesuada proin libero nunc consequat interdum varius sit amet. Odio pellentesque
            diam volutpat commodo sed egestas. Eget nunc lobortis mattis aliquam. Cursus vitae congue
            mauris rhoncus aenean vel. Pretium viverra suspendisse potenti nullam ac tortor vitae.
            A pellentesque sit amet porttitor eget dolor. Nisl nunc mi ipsum faucibus vitae. Purus sit amet
            luctus venenatis lectus magna fringilla urna. Sit amet tellus cras adipiscing enim. Euismod
            nisi porta lorem mollis aliquam ut porttitor leo.

            Morbi blandit cursus risus at ultrices. Adipiscing vitae proin sagittis nisl rhoncus mattis
            rhoncus. Sit amet commodo nulla facilisi. In fermentum et sollicitudin ac orci phasellus
            egestas tellus. Sit amet risus nullam eget felis. Dapibus ultrices in iaculis nunc sed
            augue lacus viverra. Dictum non consectetur a erat nam at. Odio ut enim blandit volutpat
            maecenas. Turpis cursus in hac habitasse platea. Etiam erat velit scelerisque in. Auctor
            neque vitae tempus quam pellentesque nec nam aliquam. Odio pellentesque diam volutpat commodo
            sed egestas egestas. Egestas dui id ornare arcu odio ut.
            EOF; 
        //$articlecontent = $parsedown->text($articlecontent);   

        /* first method set and get cache*/
        /*$item = $cache->getItem('markdown_'.md5($articlecontent));

        if (!$item->isHit())
        {
            $item->set($parsedown->text($articlecontent));
            $cache->save($item);
        }

        $articlecontent = $item->get();*/
        //$articlecontent = $markdownParser->parse($articlecontent);
        

        /* second method 
        $articlecontent = $cache->get('markdown_'.md5($articlecontent), function() use ($parsedown,$articlecontent){
            return $parsedown->text($articlecontent);
        });
        */
        //dd($slug, $this);
        //dump($slug, $this);
        return $this->render('articles/show.html.twig',//name of template
            [
                'article' => ucwords(str_replace('-',' ',$slug)),
                'articleContent' =>$articlecontent,
                'comments' => $comments,
            ]// array will be used in template as parameter
         );
        /*return new Response(sprintf('Будущая страница статьи: %s',
            ucwords(str_replace('-',' ',$slug))
        ));
        */
    }
}