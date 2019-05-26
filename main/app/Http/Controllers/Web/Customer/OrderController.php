<?php

namespace App\Http\Controllers\Web\Customer;

use App\Models\Order\Order;
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

    /**
     * @param Order $order
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Order $order)
    {
        $this->authorize('view', $order);
        return $this->render('edit', ['id' => $order->id]);
    }
}
