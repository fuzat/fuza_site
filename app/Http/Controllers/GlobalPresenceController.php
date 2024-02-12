<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Constant;
use App\Models\GlobalPresence;
use App\Models\Menu;
use Illuminate\Http\Request;

class GlobalPresenceController extends BaseController
{
    public function index(Request $request)
    {
        $page_setting = ['title' => __('datametas.web.title.global-presence')];
        $active = Constant::STATUS_ACTIVE;

        $menu_id = new Menu();
        $menu_id = optional($menu_id->filter(1, ['route_name' => 'front.global-presence', 'status' => $active]))->id;

        $banner = null;
        if (!empty($menu_id)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'relationship' => ['media', 'media_mobile'],
                'position' => BannerPosition::_PAGE_POST,
                'status' => $active,
                'menu' => $menu_id,
            ]);
        }

        $sort = $request->has('ordering') ? $request->input('ordering') : 'asc';

        $data = new GlobalPresence();
        $data = $data->filter(0, [
            'ordering'  => ['headquarter' => 'asc', 'created_at' => $sort],
            'status'    => $active,
        ]);

        $vars = ['page_setting', 'banner', 'data', 'sort', 'menu_id'];
        return view('front.global-presence', compact($vars));
    }
}
