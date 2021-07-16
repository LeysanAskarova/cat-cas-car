<?php
namespace App\Service;


use Demontpx\ParsedownBundle\Parsedown;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownParser
{
    /**
     * @var Parsedown
     */
    private $parsedown;
    /**
     * @var AdapterInterface
     */
    private $cache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $debug;

    public function __construct(
        Parsedown $parsedown, 
        AdapterInterface $cache, 
        LoggerInterface $markdownLogger, 
        bool $debug
    ) {
        $this->parsedown = $parsedown;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
        $this->debug = $debug;
    }

    public function parse(string $source): string
    {
        if(strpos($source, 'красн') !== false)
        {
            $this->logger->info('Кажется эта статья о красной точке');
        }

        if($this->debug)
        {
            return $this->parsedown->text($source);
        }
        
        $item = $this->cache->getItem('markdown_'.md5($source));

        if (!$item->isHit())
        {
            $item->set($this->parsedown->text($source));
            $this->cache->save($item);
        }

        return $source = $item->get();
    }
}