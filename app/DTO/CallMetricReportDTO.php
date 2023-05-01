<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 7/21/2018
 * Time: 4:37 PM.
 */

namespace App\DTO;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class CallMetricReportDTO implements \JsonSerializable
{
    public $metricMapping;
    public $metrics;
    public $series;
    /**
     * Undocumented variable.
     *
     * @var LengthAwarePaginator
     */
    public $groups;
    public $aggregation;

    public function __construct()
    {
        $this->metricMapping = __('global.call-metrics.metrics');
        $this->groups = new Paginator([], 0, 10, 1);
    }

    public function getDisplayableValue($metric, $metricData)
    {
        $valuePercentFormatter = function ($metric) {
            return $metric->value.(isset($metric->percent) ? ' ('.$metric->percent.')' : '');
        };
        $valueFormatter = function ($metric) {
            return $metric->value;
        };
        $sumFormatter = function ($metric) {
            return $metric->sum;
        };
        $metricFormatters = [
            'total'        => $valuePercentFormatter,
            'period_unique'=> $valuePercentFormatter,
            'global_unique'=> $valuePercentFormatter,
            'ring_time'    => $sumFormatter,
            'talk_time'    => $sumFormatter,
            'duration'     => $sumFormatter,
            'score'        => function ($metric) {
                return $metric->count;
            },
            'conversion'     => $valueFormatter,
            'revenue'        => $valueFormatter,
            'conversion_rate'=> $valueFormatter,
        ];

        return $metricFormatters[$metric]($metricData);
    }

    public function jsonSerialize()
    {
        return [
            'groups'=> $this->groups,
        ];
    }
}
