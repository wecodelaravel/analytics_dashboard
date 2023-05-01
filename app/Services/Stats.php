<?php

namespace App\Services;

class Stats
{
    // public function productCount($start = null, $end = null) {
    // 	$data = new Product();
    // 	if ($start) {
    // 		$data = $data->whereDate('created_at', '>=', $start->format('Y-m-d'));
    // 	}
    // 	if ($end) {
    // 		$data = $data->whereDate('created_at', '<=', $end->format('Y-m-d'));
    // 	}
    // 	$count = $data->count();
    // 	return number_format($count);
    // }

    // public function customerCount($start = null, $end = null) {
    // 	$data = new User();
    // 	if ($start) {
    // 		$data = $data->whereDate('created_at', '>=', $start->format('Y-m-d'));
    // 	}
    // 	if ($end) {
    // 		$data = $data->whereDate('created_at', '<=', $end->format('Y-m-d'));
    // 	}
    // 	$count = $data->count();
    // 	return number_format($count);
    // }

    // public function orderCount($start = null, $end = null) {
    // 	$data = new Order();
    // 	if ($start) {
    // 		$data = $data->whereDate('created_at', '>=', $start->format('Y-m-d'));
    // 	}
    // 	if ($end) {
    // 		$data = $data->whereDate('created_at', '<=', $end->format('Y-m-d'));
    // 	}
    // 	$count = $data->count();
    // 	return number_format($count);
    // }

    // public function totalSales($start = null, $end = null) {
    // 	$o = new Order();
    // 	$sales = $o->totalSales($start, $end);
    // 	return '$' . number_format($sales);
    // }

    // public function getHighestSellingProducts($limit = null, $start = null, $end = null) {
    // 	$p = new Product();
    // 	$products = $p->getHighestSellingProducts($limit, $start, $end);
    // 	return $products;
    // }

    // public function messages($limit = null, $start = null, $end = null) {
    // 	$messages = FormPost::orderBy('id', 'desc');
    // 	if ($start) {
    // 		$messages = $messages->whereDate('created_at', '>=', $start->format('Y-m-d'));
    // 	}
    // 	if ($end) {
    // 		$messages = $messages->whereDate('created_at', '<=', $end->format('Y-m-d'));
    // 	}
    // 	if ($limit) {
    // 		$messages = $messages->limit($limit);
    // 	}
    // 	$messages = $messages->get();
    // 	return $messages;
    // }

    // public function totalOrdersByDate($start = null, $end = null) {
    // 	$o = new Order();
    // 	$data = $o->totalOrdersByDate($start, $end);
    // 	return $data;
    // }

    // public function totalRevenueByDate($start = null, $end = null) {
    // 	$o = new Order();
    // 	$data = $o->totalRevenueByDate($start, $end);
    // 	return $data;
    // }
}
