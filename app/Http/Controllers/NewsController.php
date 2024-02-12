<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Category;
use App\Models\Constant;
use App\Models\Menu;
use App\Models\News;
use App\Models\HashKey;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    private $_view = 'front.news.';
    private $_menu_id;

    public function __construct()
    {
        parent::__construct();

        $this->_menu_id = new Menu();
        $this->_menu_id = optional($this->_menu_id->filter(1, [
            'route_name' => 'front.news.index',
            'status' => Constant::STATUS_ACTIVE,
        ], ['id']))->id;
    }

    public function index()
    {
        $active = Constant::STATUS_ACTIVE;
        $page_setting = ['title' => __('datametas.web.title.news')];

        $categories = null;
        if (!empty($this->_menu_id))
            $categories = Category::getList(['menu_id' => $this->_menu_id, 'ordering' => ['created_at' => 'asc']]);

        $banner = null;
        if (!empty($this->_menu_id)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'position'      => BannerPosition::_PAGE_POST,
                'relationship'  => ['media', 'media_mobile'],
                'menu'          => $this->_menu_id,
                'status'        => $active,
            ]);
        }

        $params = \Input::all();
        $category_id = isset($params['category']) ? $params['category'] : array_key_first($categories);

        $hot_news = new News();
        $hot_news = $hot_news->filter(0, [
            'ordering'      => ['public_date' => 'desc'],
            'relationship'  => ['media_big', 'carousel', 'video'],
            'category'      => $category_id,
            'hot_news'      => $active,
            'status'        => $active,
            'show_date'     => $active,
            'limit'         => 3,
        ]);

        $data = new News();
        $data = $data->filter(Constant::PER_PAGE_6, [
            'ordering'      => ['public_date' => 'desc'],
            'relationship'  => ['media_detail'],
            'hot_news'      => Constant::STATUS_INACTIVE,
            'category'      => $category_id,
            'status'        => $active,
            'show_date'     => $active,
        ]);

        $menu_id = $this->_menu_id;
        $vars = ['page_setting', 'categories', 'banner', 'hot_news', 'data', 'params', 'menu_id'];
        return view($this->_view . 'index', compact($vars));
    }

    public function show($slug, $hash_key)
    {
        $active = Constant::STATUS_ACTIVE;
        $id = optional(HashKey::getData(HashKey::_OBJ_TYPE_NEWS, $hash_key))->obj_id;

        $data = new News();
        $data = $data->filter(1, [
            'relationship'  => ['media_detail'],
            'show_date'     => $active,
            'status'        => $active,
            'slug'          => $slug,
            'id'            => $id,
        ]);

        if (empty($data))
            return abort(404);

        $categories = null;
        if (!empty($this->_menu_id))
            $categories = Category::getList(['menu_id' => $this->_menu_id, 'ordering' => ['created_at' => 'asc']]);

        $banner = null;
        if (!empty($this->_menu_id)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'position'      => BannerPosition::_PAGE_POST,
                'relationship'  => ['media', 'media_mobile'],
                'menu'          => $this->_menu_id,
                'status'        => $active,
            ]);
        }

        $similars = new News();
        $similars = $similars->filter(0, [
            'ordering'      => ['public_date' => 'desc'],
            'relationship'  => ['media_detail'],
            'not_id'        => $id,
            'status'        => $active,
            'show_date'     => $active,
            'category'      => $data->category_id,
            'limit'         => Constant::PER_PAGE_6,
        ]);

        $data->view++;
        $data->save();

        $seo = [
            'title'         => optional($data->datameta('', 'seo_title'))->data_value,
            'description'   => optional($data->datameta('', 'seo_description'))->data_value,
            'image'         => !empty($data->media) ? asset($data->media->web_path) : null,
        ];

        $menu_id = $this->_menu_id;
        $page_setting = ['title' => optional($data->datameta('', 'name'))->data_value];

        $vars = ['page_setting', 'categories', 'similars', 'banner', 'data', 'menu_id', 'seo'];
        return view($this->_view . 'show', compact($vars));
    }
}
