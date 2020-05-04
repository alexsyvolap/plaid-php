<?php


namespace san4o101\Plaid;

use Capsule\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use san4o101\Plaid\Exceptions\PlaidRequestException;
use Shuttle\Shuttle;

class RequestBuilder
{

    /**
     * Host
     * @var string
     */
    private $host;

    /**
     * Plaid API version
     * @var string
     */
    private $version;

    /**
     * HTTP client
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * RequestBuilder constructor.
     * @param string $host
     * @param string $version
     */
    public function __construct(string $host, string $version)
    {
        $this->host = $host;
        $this->version = $version;
    }

    /**
     * Get HTTP client
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        if( empty($this->httpClient) ) {
            $this->httpClient = new Shuttle;
        }

        return $this->httpClient;
    }

    /**
     * Set HTTP client
     * @param ClientInterface $client
     */
    public function setHttpClient(ClientInterface $client): void
    {
        $this->httpClient = $client;
    }

    /**
     * Process the request and decode response as JSON.
     * @param RequestInterface $request
     * @return object
     * @throws PlaidRequestException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function doRequest(RequestInterface $request): object
    {
        $response = $this->getHttpClient()->sendRequest($request);

        if( $response->getStatusCode() < 200 || $response->getStatusCode() >= 300 ){
            throw new PlaidRequestException($response);
        }

        return \json_decode($response->getBody()->getContents());
    }

    public function buildRequest(string $method, string $path, array $params = []): RequestInterface
    {
        return new Request(
            $method,
            ($this->host ?? '') . $path,
            json_encode($params),
            [
                "Plaid-Version" => $this->version,
                "Content-Type" => "application/json"
            ]
        );
    }
}
