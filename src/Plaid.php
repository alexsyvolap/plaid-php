<?php


namespace san4o101\Plaid;


use san4o101\Plaid\API\Client;
use san4o101\Plaid\Exceptions\PlaidException;

class Plaid
{

    /**
     * Package version
     */
    public const VERSION = '0.0.2';

    /**
     * Host environment
     * @var string
     */
    private $environment = 'production';

    /**
     * URL's environments
     * @var string[]
     */
    private $defaultEnvironments = [
        'production' => 'https://production.plaid.com/',
        'development' => 'https://development.plaid.com/',
        'sandbox' => 'https://sandbox.plaid.com/',
    ];

    /**
     * API version
     * @var string
     */
    private $version = '2019-05-29';

    /**
     * API versions
     * @var string[]
     */
    private $defaultVersions = [
        '2017-03-08',
        '2018-05-22',
        '2019-05-29',
    ];

    /**
     * Client
     * @var Client
     */
    private $client;

    /**
     * HTTP client
     * @var RequestBuilder
     */
    private $httpClient;

    /**
     * Plaid constructor.
     * @param string $clientId
     * @param string $secret
     * @param string $publicKey
     * @param string $environment
     * @param string $version
     * @throws PlaidException
     */
    public function __construct(string $clientId, string $secret, string $publicKey, string $environment = 'production', string $version = '2019-05-29')
    {
        $this->setEnvironment($environment);
        $this->setVersion($version);

        $this->httpClient = new RequestBuilder($this->getHost($this->environment), $this->version);
        $this->client = new Client($clientId, $secret, $publicKey, $this->httpClient);
    }

    /**
     * @param string $environment
     * @throws PlaidException
     */
    public function setEnvironment(string $environment): void
    {
        if( !array_key_exists($environment, $this->defaultEnvironments) ) {
            throw new PlaidException('Unknown environment {'.$environment.'}');
        }

        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @param string $version
     * @throws PlaidException
     */
    public function setVersion(string $version): void
    {
        if( !in_array($version, $this->defaultVersions) ) {
            throw new PlaidException('Unknown version {'.$version.'}');
        }

        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $environment
     * @return string|null
     */
    public function getHost(string $environment): ?string
    {
        return $this->defaultEnvironments[$environment] ?? null;
    }

    public function client()
    {
        return $this->client;
    }


}
