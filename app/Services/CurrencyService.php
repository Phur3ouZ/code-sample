<?php

namespace App\Services;

class CurrencyService extends BaseService
{
    public function __construct(?array $config = null)
    {
        // Allow optional configuration overrides, otherwise fallback to defaults
        $config ??= [
            'base_uri' => 'https://free.currconv.com/',
        ];

        parent::__construct($config);
    }

    /**
     * Ensure that the apiKey is set with every request
     *  This would be refactored to encapsulate all request types, not just GET requests
     *
     * @param  string  $uri
     * @param  array  $options
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $options = []): array
    {
        $options['query'] = array_merge([
            'apiKey' => 'd82745f75be6b3f4a0a0', // TODO - shift into environment variable
        ], $options['query'] ?? []);

        return parent::get($uri, $options);
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrencies(): array
    {
        $response = $this->get('api/v7/currencies');

        return $response['results'];
    }

    /**
     * @param  string  $currencyFrom
     * @param  string  $currencyTo
     * @return float
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConversionRate(string $currencyFrom, string $currencyTo): float
    {
        $key = "{$currencyFrom}_{$currencyTo}";
        $response = $this->get('api/v7/convert', [
            'query' => [
                'q' => $key,
                'compact' => 'ultra',
            ],
        ]);

        return $response[$key];
    }
}
