<?php


namespace san4o101\Plaid\API;


use Psr\Http\Client\ClientExceptionInterface;
use san4o101\Plaid\Exceptions\PlaidRequestException;
use san4o101\Plaid\RequestBuilder;
use san4o101\Plaid\RequestBuilderTrait;

class Client
{

    /**
     * Client ID
     * @var string
     */
    private $clientId;

    /**
     * Public Key
     * @var string
     */
    private $publicKey;

    /**
     * Client secret
     * @var string
     */
    private $secret;

    /**
     * HTTP client
     * @var RequestBuilder
     */
    private $httpClient;

    /**
     * Client constructor.
     * @param string $clientId
     * @param string $publicKey
     * @param string $secret
     * @param RequestBuilder $httpClient
     */
    public function __construct(string $clientId, string $publicKey, string $secret, RequestBuilder $httpClient)
    {
        $this->clientId = $clientId;
        $this->publicKey = $publicKey;
        $this->secret = $secret;
        $this->httpClient = $httpClient;
    }

    /**
     * Client credentials
     * @param array $params
     * @return array
     */
    public function credentials(array $params = []): array
    {
        return array_merge([
            'client_id' => $this->clientId,
            'secret' => $this->secret,
        ], $params);
    }

    /**
     * Public client credentials
     * @param array $params
     * @return array
     */
    public function publicCredentials(array $params = []): array
    {
        return array_merge([
            'public_key' => $this->publicKey
        ], $params);
    }

    /**
     * @param string $access_token
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getAuth(string $access_token, array $options = []): object
    {
        $params = [
            'access_token' => $access_token,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'auth/get', $this->credentials($params))
        );
    }

    /**
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getCategories(): object
    {
        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'categories/get', $this->credentials())
        );
    }

    /**
     * @param string $access_token
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getLiabilities(string $access_token, array $options = []): object
    {
        $params = [
            'access_token' => $access_token,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'liabilities/get', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getItem(string $access_token): object
    {
        $params = [
            'access_token' => $access_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'item/get', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function removeItem(string $access_token): object
    {
        $params = [
            'access_token' => $access_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'item/remove', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function createPublicToken(string $access_token): object
    {
        $params = [
            'access_token' => $access_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'item/public_token/create', $this->credentials($params))
        );
    }

    /**
     * @param string $public_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function exchangeToken(string $public_token): object
    {
        $params = [
            'public_token' => $public_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'item/public_token/exchange', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function rotateAccessToken(string $access_token): object
    {
        $params = [
            'access_token' => $access_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'item/access_token/invalidate', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @param string $account_id
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function createStripeToken(string $access_token, string $account_id): object
    {
        $params = [
            'access_token' => $access_token,
            'account_id' => $account_id,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'processor/stripe/bank_account_token/create', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @param string $webhook
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function updateWebhook(string $access_token, string $webhook): object
    {
        $params = [
            'access_token' => $access_token,
            'webhook' => $webhook,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'item/webhook/update', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getAccounts(string $access_token): object
    {
        $params = [
            'access_token' => $access_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'accounts/get', $this->credentials($params))
        );
    }

    /**
     * @param string $institution_id
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getInstitution(string $institution_id, array $options = []): object
    {
        $params = [
            'institution_id' => $institution_id,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'institution/get_by_id', $this->publicCredentials($params))
        );
    }

    /**
     * @param int $count
     * @param int $offset
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getInstitutions(int $count, int $offset, array $options = []): object
    {
        $params = [
            'count' => $count,
            'offset' => $offset,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'institutions/get', $this->credentials($params))
        );
    }

    /**
     * @param string $query
     * @param array $products
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function findInstitution(string $query, array $products, array $options = []): object
    {
        $params = [
            'query' => $query,
            'products' => $products,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'institutions/search', $this->publicCredentials($params))
        );
    }

    /**
     * @param string $access_token
     * @param \DateTime $start_date
     * @param \DateTime $end_date
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getTransactions(string $access_token, \DateTime $start_date, \DateTime $end_date, array $options = []): object
    {
        $params = [
            'access_token' => $access_token,
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'transactions/get', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getBalance(string $access_token, array $options = []): object
    {
        $params = [
            'access_token' => $access_token,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'accounts/balance/get', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getIdentity(string $access_token): object
    {
        $params = [
            'access_token' => $access_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'identity/get', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getIncome(string $access_token): object
    {
        $params = [
            'access_token' => $access_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'income/get', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @param int $days_requested
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function createAssetReport(string $access_token, int $days_requested, array $options = []): object
    {
        $params = [
            'access_token' => $access_token,
            'days_requested' => $days_requested,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'asset_report/create', $this->credentials($params))
        );
    }

    /**
     * @param string $asset_report_token
     * @param int $days_requested
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function refreshAssetReport(string $asset_report_token, int $days_requested, array $options = []): object
    {
        $params = [
            'asset_report_token' => $asset_report_token,
            'days_requested' => $days_requested,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'asset_report/refresh', $this->credentials($params))
        );
    }

    /**
     * @param string $asset_report_token
     * @param array $exclude_accounts
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function filterAssetReport(string $asset_report_token, array $exclude_accounts): object
    {
        $params = [
            'asset_report_token' => $asset_report_token,
            'account_ids_to_exclude' => $exclude_accounts,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'asset_report/filter', $this->credentials($params))
        );
    }

    /**
     * @param string $asset_report_token
     * @param bool $include_insights
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getAssetReport(string $asset_report_token, bool $include_insights = false): object
    {
        $params = [
            "asset_report_token" => $asset_report_token,
            "include_insights" => $include_insights
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'asset_report/get', $this->credentials($params))
        );
    }

    /**
     * @param string $asset_report_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function removeAssetReport(string $asset_report_token): object
    {
        $params = [
            'asset_report_token' => $asset_report_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'asset_report/remove', $this->credentials($params))
        );
    }

    /**
     * @param string $asset_report_token
     * @param string $auditor_id
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function createAssetReportAuditCopy(string $asset_report_token, string $auditor_id): object
    {
        $params = [
            'asset_report_token' => $asset_report_token,
            'auditor_id' => $auditor_id,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'asset_report/audit_copy/create', $this->credentials($params))
        );
    }

    /**
     * @param string $audit_copy_token
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function removeAssetReportAuditCopy(string $audit_copy_token): object
    {
        $params = [
            'audit_copy_token' => $audit_copy_token,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'asset_report/audit_copy/remove', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getInvestmentHoldings(string $access_token, array $options = []): object
    {
        $params = [
            'access_token' => $access_token,
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'investments/holdings/get', $this->credentials($params))
        );
    }

    /**
     * @param string $access_token
     * @param \DateTime $start_date
     * @param \DateTime $end_date
     * @param array $options
     * @return object
     * @throws ClientExceptionInterface
     * @throws PlaidRequestException
     */
    public function getInvestmentTransactions(string $access_token, \DateTime $start_date, \DateTime $end_date, array $options = []): object
    {
        $params = [
            'access_token' => $access_token,
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'options' => (object)$options,
        ];

        return $this->httpClient->doRequest(
            $this->httpClient->buildRequest('post', 'investments/transactions/get', $this->credentials($params))
        );
    }
}
