<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Web\Controller;

class OrderController extends Controller
{
    /**
     * @return string
     */
    protected function viewPath(): string
    {
        return 'customer.orders';
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->render('index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->render('create');
    }
}