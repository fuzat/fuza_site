<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Business;
use App\Models\Constant;
use App\Models\Group;
use App\Models\Menu;
use App\Models\Partner;
use App\Models\Post;
use App\Models\SearchResult;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $page_setting = ['title' => __('datametas.web.title.home')];

        $active = Constant::STATUS_ACTIVE;

        $banners = new Banner();
        $banners = $banners->filter(0, [
            'relationship'  => ['media', 'media_mobile'],
            'status'        => $active,
            'menu'          => Menu::_MENU_HOME_VAL,
        ]);

        $post = new Post();
        $post = $post->filter(0, [
            'type'      => Post::_TYPE_HOME,
            'status'    => $active,
        ]);

        $partners = new Partner();
        $partners = $partners->filter(0, [
            'ordering' => ['created_at' => 'asc'],
            'relationship' => ['media'],
            'status' => $active,
        ]);

        $businesses = new Business();
        $businesses = $businesses->filter(0, [
            'relationship' => ['icon', 'icon_act', 'file_home'],
            'ordering' => ['created_at' => 'asc'],
            'show_home' => $active,
            'status' => $active,
        ]);

        $groups = new Group();
        $groups = $groups->filter(0, [
            'relationship' => ['media'],
            'ordering' => ['created_at' => 'asc'],
            'status' => $active,
        ]);

        $vars = ['page_setting', 'partners', 'businesses', 'groups', 'banners', 'post'];
        return view('front.home', compact($vars));
    }

    public function search(Request $request)
    {
        $search = $request->all();
        $search['relationship'] = ['job.media', 'news.media_detail', 'business.file'];

        $banner = new Banner();
        $banner = $banner->filter(1, [
            'relationship' => ['media', 'media_mobile'],
            'ordering' => ['created_at' => 'asc'],
            'status' => Constant::STATUS_ACTIVE,
            'menu' => Menu::_MENU_SEARCH_VAL,
        ]);

        $data = new SearchResult();
        $data = $data->filter(Constant::PER_PAGE_10, $search);

        unset($search['relationship']);
        $page_setting = ['title' => __('datametas.web.title.search')];
        return view('front.search', compact(['page_setting', 'search', 'banner', 'data']));
    }
}
