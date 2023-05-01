<?php

namespace App\Services;

use App\DTO\CallMetricReportOptions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\RejectionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class CallMetricApi
{
    protected $token;
    protected $serviceConfig;
    protected $client;

    public function __construct()
    {
        $this->serviceConfig = config('services.callmetric');
        $this->client = new Client([
            'base_uri' => 'https://api.calltrackingmetrics.com/api/v1/',
        ]);
    }

    /**
     * @param $url
     * @param string $method
     * @param array  $options
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function executeRequest($url, $method = 'GET', $options = [])
    {
        return $this->client->request($method, $url, $this->buildOptions($options));
    }

    protected function buildOptions($options)
    {
        $token = base64_encode($this->serviceConfig['api_key'].':'.$this->serviceConfig['api_secret']);
        if (!isset($options['headers'])) {
            $options['headers'] = [];
        }
        if (!isset($options['headers']['Authorization'])) {
            $options['headers']['Authorization'] = "Basic $token";
        }

        return $options;
    }

    /**
     * Undocumented function.
     *
     * @param [type] $accountId
     * @param int    $page
     * @param [type] $number
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getNumbersForAccountAsync($accountId, $page = 1, $number = null)
    {
        $paginator = new LengthAwarePaginator([], 0, 10, 1);
        if (empty($page) || $page < 1) {
            $page = 1;
        }

        $params = [
            'page' => $page,
        ];

        if ($number !== null) {
            $params['number'] = $number;
        }

        return $this->client->requestAsync('GET', "accounts/$accountId/numbers.json", $this->buildOptions([
            'query'=> $params,
        ]))->then(function (ResponseInterface $response) use ($paginator) {
            $jsonResponse = $response->getBody()->getContents();

            if (!empty($jsonResponse)) {
                $decoded = json_decode($jsonResponse);
                $paginator = new LengthAwarePaginator($decoded->numbers, $decoded->total_entries, $decoded->per_page, $decoded->page);
            }

            return $paginator;
        }, function (RejectionException $e) {
            report($e);
        });
    }

    /**
     * @return mixed|null
     */
    public function getReportSeries($accountId, CallMetricReportOptions $options)
    {
        if (empty($options->page) || $options->page < 1) {
            $options->page = 1;
        }

        $decoded = null;
        $form_params = [
            'with_time' => 1,
            'page'      => $options->page,
            'direction' => [
                'form',
                'inbound',
                'outbound',
            ],
            'multi_tracking_numbers_operator'=> 'includes',
            'by'                             => $options->dimension,
            'multi_tracking_numbers'         => implode(',', $options->tracking_numbers_filter_ids),
            'sort'                           => $options->sort,
            'dir'                            => $options->sortDir,
            'start_date'                     => $options->start_date->format('Y-m-d'),
            'end_date'                       => $options->end_date->format('Y-m-d'),
        ];

        try {
            $resp = $this->executeRequest("accounts/$accountId/reports/series.json", 'GET', [
                'form_params' => $form_params,
            ]);
            $jsonResponse = $resp->getBody()->getContents();

            if (!empty($jsonResponse)) {
                $decoded = json_decode($jsonResponse);
            }
        } catch (GuzzleException $e) {
            report($e);
        }

        return $decoded;
    }

    public function getAllAccounts()
    {
        $collection = new Collection();

        try {
            $resp = $this->executeRequest('accounts.json', 'GET', [
                'query'=> [
                    'names'=> 1,
                    'all'  => 1,
                ],
            ]);
            $jsonResponse = $resp->getBody()->getContents();

            if (!empty($jsonResponse)) {
                $collection = new Collection(json_decode($jsonResponse)->accounts);
            }
        } catch (GuzzleException $e) {
            report($e);
        }

        return $collection;
    }
}
