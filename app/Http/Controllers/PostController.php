<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Constant;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Post();
    }

    public function index($hash_key)
    {
        $id = decrypt($hash_key);
        $active = Constant::STATUS_ACTIVE;

        $data = new Post();
        $data = $data->filter(1, ['type' => Post::_TYPE_POST, 'status' => $active, 'id' => $id]);

        if (empty($id) || empty($data))
            abort(404);

        $banner = null;

        if (!empty($data->banner)) {
            $banner = $data->banner()->where('status', $active)->first();
        }

        if (empty($banner)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'position'      => BannerPosition::_PAGE_POST,
                'relationship'  => ['media', 'media_mobile'],
                'menu'          => $data->menu_id,
                'status'        => $active,
            ]);
        }

        $page_setting = ['title' => optional($data->datameta('', 'title'))->data_value];

        $seo = [
            'title'         => optional($data->datameta('', 'seo_title'))->data_value,
            'description'   => optional($data->datameta('', 'seo_description'))->data_value,
            'image'         => null,
        ];

        $post_id = $data->id;
        return view('front.post.index', compact(['banner', 'page_setting', 'data', 'post_id', 'seo']));

    }

    public function getPostsByMenu(Request $request)
    {
        $params = [
            'menu_status' => Constant::STATUS_ACTIVE,
            'not_have' => 'banner',
        ];

        if (!empty($request->input('menu_id')))
            $params['menu'] = $request->input('menu_id');
        else
            $params['menu'] = -1000;

        if (!empty($request->input('except_id')))
            $params['except_id'] = $request->input('except_id');

        if (!empty($request->input('menu_route_name')))
            $params['menu_route_name'] = $request->input('menu_route_name');

        $data = Post::getList($params);

        return $this->getSuccessJson('', $data);
    }
}
