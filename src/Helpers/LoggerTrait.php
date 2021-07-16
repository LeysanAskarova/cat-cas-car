<?php
namespace App\Helpers;

//use App\Service\MarkdownParser;
use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @param LoggerInterface
     * @required
     */
    public function setLogger(LoggerInterface $logger) 
    {
        $this->logger = $logger;
    }

    public function logInfo(string $message, array $context = [])
    {
        if($this->logger)
        {
            $this->logger->info($message, $context);
        }
    }

    /**
     * @param MarkdownParser
     * @required
     */
    /*public function example(MarkdownParser $markdownParser)
    {
        dump($markdownParser->parse('#Hello'));
    }
    */

}