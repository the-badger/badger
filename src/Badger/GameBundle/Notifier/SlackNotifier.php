<?php

namespace Badger\GameBundle\Notifier;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Slack implementation of the NotifierInterface.
 * It makes a CURL call to the slack api to send a message to a given channel.
 *
 * @author  Adrien Pétremann <adrien.petremann@akeneo.com>
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class SlackNotifier implements NotifierInterface
{
    /** @var string */
    private $webhookUrl;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param string          $webhookUrl
     * @param LoggerInterface $logger
     */
    public function __construct($webhookUrl, LoggerInterface $logger)
    {
        $this->webhookUrl = $webhookUrl;
        $this->logger = $logger;
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

        $promise->then(
            function (ResponseInterface $res) use ($data) {
                $this->logger->info(
                    sprintf(
                        'Request to SLACK webhook OK [%s] with data: %s',
                        $res->getStatusCode(),
                        json_encode($data)
                    )
                );
            },
            function (RequestException $e) {
                $this->logger->error(
                    sprintf(
                        'Request to SLACK webhook FAILED with message: %s',
                        $e->getMessage()
                    )
                );
            }
        );

        $promise->wait(false);
    }
}
