<?php

namespace Ironforge\GameBundle\Notifier;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Slack implementation of the NotifierInterface.
 * It makes a CURL call to the slack api to send a message to a given channel.
 *
 * @author Adrien Pétremann <petremann.adrien@gmail.com>
 */
class SlackNotifier implements NotifierInterface
{
    /** @var string */
    private $webhookUrl;

    /**
     * @param string $webhookUrl
     */
    public function __construct($webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * @param mixed $data
     */
    public function notify($data)
    {
        $client = new Client();
        $request = new Request(
            'POST',
            $this->webhookUrl,
            ['Content-type' => 'application/json'],
            json_encode($data)
        );

        $response = $client->send($request, ['timeout' => 2]);
    }
}
