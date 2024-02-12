<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController as Controller;
use App\Models\Constant;

/**
 * Class BaseController.
 *
 * @package namespace App\Http\Controllers;
 */
class BaseController extends Controller
{
    protected $_perPage = Constant::PER_PAGE_DEFAULT;

    public function __construct()
    {
        parent::__construct();

        $locale = config('app.locale');

        if (\LaravelLocalization::getCurrentLocale() != $locale) {
            header('Location: '.\LaravelLocalization::getLocalizedURL($locale, null, [], true));
            exit;
        }

        view()->share('routing', \Route::currentRouteName());
    }
}
