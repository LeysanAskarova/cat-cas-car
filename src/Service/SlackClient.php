<?php
namespace App\Service;

use App\Helpers\LoggerTrait;
use Nexy\Slack\Client;

class SlackClient
{
    use LoggerTrait;
    /**
     * @var Client
     */
    private $slack;

    public function __construct(Client $slack)
    {
        $this->slack=$slack;
    }

    public function send(string $message, string $icon=':ghost:', string $from = 'Cat-Cas-Car')
    {
        $this->logInfo('Send message to slackk', ['message'=>$message]);

        $slackMessage = $this->slack->createMessage();
        $slackMessage
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message)
        ;

        $this->slack->sendMessage($slackMessage);
    }
}
