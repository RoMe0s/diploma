<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string $key
     * @param $value
     */
    protected final function setData(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $view
     * @param array $data
     * @return View
     */
    protected final function render(string $view, array $data = []): View
    {
        if ($viewPath = $this->viewPath()) {
            $view = $viewPath ? "$viewPath.$view" : $view;
        }
        return view($view, array_merge($this->data, $data));
    }

    /**
     * @return string
     */
    protected function viewPath(): string
    {
        return '';
    }
}
