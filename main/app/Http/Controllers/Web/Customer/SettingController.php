<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Web\Controller;

class SettingController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->render('customer.settings.index');
    }
}
