<?php

namespace App\DTO;

use Carbon\Carbon;

class CallMetricReportOptions
{
    /**
     * Undocumented variable.
     *
     * @var string
     */
    public $dimension;
    /**
     * Undocumented variable.
     *
     * @var Carbon
     */
    public $start_date;
    /**
     * Undocumented variable.
     *
     * @var Carbon
     */
    public $end_date;
    /**
     * Undocumented variable.
     *
     * @var string[]
     */
    public $tracking_numbers_filter_ids;

    public $page;
    public $sort;
    public $account_id;
    public $sortDir;

    public function __construct($account_id)
    {
        $this->dimension = 'tracking_number';
        $this->account_id = $account_id;
        $this->page = 1;
    }
}
