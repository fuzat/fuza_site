<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Business;
use App\Models\Constant;
use App\Models\Menu;
use App\Models\HashKey;

class BusinessController extends BaseController
{
    private $_view = 'front.our-business.';
    private $_menu_id = 'front.our-business.';

    public function __construct()
    {
        parent::__construct();

        $this->_menu_id = new Menu();
        $this->_menu_id = optional($this->_menu_id->filter(1, ['route_name' => 'front.our-business.index', 'status' => Constant::STATUS_ACTIVE]))->id;
    }

    public function index()
    {
        $page_setting = ['title' => __('datametas.web.title.all-sectors')];
        $active = Constant::STATUS_ACTIVE;

        $data = new Business();
        $data = $data->filter(0, [
            'ordering'      => ['created_at' => 'asc'],
            'relationship'  => ['avatar', 'file'],
            'status'        => $active,
        ]);

        $banner = new Banner();
        $banner = $banner->filter(1, [
            'position'      => BannerPosition::_PAGE_POST,
            'relationship'  => ['media', 'media_mobile'],
            'menu'          => $this->_menu_id,
            'status'        => $active,
        ]);

        $flag = 'all-sectors';
        $vars = ['page_setting', 'banner', 'data', 'flag'];
        return view($this->_view . 'all-sectors', compact($vars));
    }

    public function show($slug, $hash_key)
    {
        $id = optional(HashKey::getData(HashKey::_OBJ_TYPE_BUSINESS, $hash_key))->obj_id;
        $active = Constant::STATUS_ACTIVE;

        $data = new Business();
        $data = $data->filter(1, ['status' => $active, 'id' => $id, 'slug' => $slug]);

        if (empty($data))
            return abort(404);

        $banner = new Banner();
        $banner = $banner->filter(1, [
            'position'      => BannerPosition::_PAGE_POST,
            'relationship'  => ['media', 'media_mobile'],
            'menu'          => $this->_menu_id,
            'status'        => $active,
        ]);

        $seo = [
            'title'         => optional($data->datameta('', 'name'))->data_value,
            'description'   => optional($data->datameta('', 'short-desc'))->data_value,
            'image'         => !empty($data->file) ? asset($data->file->web_path) : null,
        ];

        $business_id = $id;
        $vars = ['business_id', 'banner', 'data', 'seo'];
        return view($this->_view . 'detail-sector', compact($vars));
    }
}
