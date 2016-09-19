<?php

namespace Badger\GameBundle\Notifier;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Slack implementation of the NotifierInterface.
 * It makes a CURL call to the slack api to send a message to a given channel.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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

        $promise = $client->sendAsync($request, ['timeout' => 10]);
        $promise->wait(false);
    }
}
