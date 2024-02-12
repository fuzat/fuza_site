<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Constant;
use App\Models\Datameta;
use App\Models\Media;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;

class BannerController extends BaseController
{
    private $_view = 'admin.banners.';
    private $_attr = Banner::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Banner();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->all();
        $search['relationship'] = ['media', 'post', 'menu'];
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.banner.index'), 'attr' => $this->_attr];
        unset($search['relationship']);

        $banner_positions = BannerPosition::getAll();

        $menus[-1] = __('datametas.title.home');
        $arr = Menu::getList(['ordering' => ['created_at' => 'asc']]);
        foreach ($arr as $k => $v)
            $menus[$k] = $v;

        $vars = ['data', 'menus', 'search', 'page_setting', 'banner_positions'];
        return view($this->_view . 'index', compact($vars));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner_positions = BannerPosition::getAll();

        $menus[-1] = __('datametas.web.title.home');
        $menus[-2] = __('datametas.web.title.search');
        $menus[-3] = __('datametas.web.title.join-talent-community');
        $arr = Menu::getList(['ordering' => ['created_at' => 'asc'], 'parent_id_null' => true]);
        foreach ($arr as $k => $v)
            $menus[$k] = $v;

        $page_setting = ['title' => __('datametas.title.banner.create'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['page_setting', 'menus', 'banner_positions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if ($validator = $this->_model->validation($input))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input)) {

            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_BANNER, ['locale' => $input['locale']]);
            }

            if ($request->hasFile($this->_attr . '-mobile_file')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-mobile_file'), $id, Media::OBJ_TYPE_BANNER_MOBILE, ['locale' => $input['locale']]);
            }

            return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.create.success'));
        }

        return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.create.fail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$data = $this->_model->filter(1, ['id' => $id]))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        $banner_positions = BannerPosition::getAll();

        $menus[-1] = __('datametas.title.home');
        $menus[-2] = __('datametas.web.title.search');
        $menus[-3] = __('datametas.web.title.join-talent-community');
        $arr = Menu::getList(['ordering' => ['created_at' => 'asc'], 'parent_id_null' => true]);
        foreach ($arr as $k => $v)
            $menus[$k] = $v;

        $posts = Post::getList(['menu' => $data->menu_id, 'menu_status' => Constant::STATUS_ACTIVE, 'not_have' => 'banner', 'except_id' => $data->post_id]);

        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.banner.edit'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['id', 'data', 'lang', 'menus', 'posts', 'page_setting', 'banner_positions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        if ($validator = $this->_model->validation($input, $id))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input, $id)) {

            $data = $this->_model->filter(1, ['id' => $id]);

            if ($request->hasFile($this->_attr . '-mobile_file')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_BANNER, ['locale' => $input['locale']]);
            } else {
                if (empty($data->getLocaleMedia($input['locale'], Media::OBJ_TYPE_BANNER))) {
                    if (!empty($media = $data->getLocaleMedia(env('APP_LOCALE'), Media::OBJ_TYPE_BANNER))) {
                        $media = $media->toArray();
                        $media['locale'] = $input['locale'];
                        unset($media['id']);
                        Media::query()->insert($media);
                    }
                }
            }

            if ($request->hasFile($this->_attr . '-mobile_file')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-mobile_file'), $id, Media::OBJ_TYPE_BANNER_MOBILE, ['locale' => $input['locale']]);
            } else {
                if (empty($data->getLocaleMedia($input['locale'], Media::OBJ_TYPE_BANNER_MOBILE))) {
                    if (!empty($media = $data->getLocaleMedia(env('APP_LOCALE'), Media::OBJ_TYPE_BANNER_MOBILE))) {
                        $media = $media->toArray();
                        $media['locale'] = $input['locale'];
                        unset($media['id']);
                        Media::query()->insert($media);
                    }
                }
            }

            return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.update.success'));
        }

        return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.update.fail'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$data = $this->_model->filter(1, ['id' => $id]))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        Media::removeRecord($data->id, [Media::OBJ_TYPE_BANNER, Media::OBJ_TYPE_BANNER_MOBILE]);
        Datameta::removeRecord($data->id, Datameta::TYPE_BANNER);
        $data->delete();

        return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.delete.success'));
    }

    /**
     * Change board-director's column status value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($id) || empty($data))
            return $this->getErrorJson(trans('custom.msg.error.no-data'));

        $data->status = ($data->status == Constant::STATUS_ACTIVE) ? Constant::STATUS_INACTIVE : Constant::STATUS_ACTIVE;
        $data->save();

        return $this->getSuccessJson(trans('custom.msg.update.success'));
    }

    /**
     * Get the locale media type web and type mobile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLocaleMedias(Request $request)
    {
        $arr = [];
        $id = $request->get('id');
        $lang = $request->get('lang');
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($id) || empty($data))
            return $this->getErrorJson(trans('custom.msg.error.no-data'));

        if (empty($data->getLocaleMedia($lang, Media::OBJ_TYPE_BANNER)))
            $arr['media'] = $data->getLocaleMedia(env('APP_LOCALE'), Media::OBJ_TYPE_BANNER);

        if (empty($data->getLocaleMedia($lang, Media::OBJ_TYPE_BANNER_MOBILE)))
            $arr['media_mobile'] = $data->getLocaleMedia(env('APP_LOCALE'), Media::OBJ_TYPE_BANNER_MOBILE);

        return $this->getSuccessJson('', $arr);
    }
}
