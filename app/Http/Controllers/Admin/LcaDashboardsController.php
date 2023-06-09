<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;

class LcaDashboardsController extends Controller
{
    /**
     * @var mixed
     */
    protected $bookings;

    /**
     * @param Booking $bookings
     */
    public function __construct(Booking $bookings)
    {
        $this->booking = $bookings;
    }

    public function index()
    {
        $total_bookings = Booking::all()->count();

        return view('admin.lca_dashboards.index', compact('total_bookings'));
    }
}
