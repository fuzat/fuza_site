<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Constant;
use App\Models\Datameta;
use App\Models\HashKey;
use App\Models\Media;
use App\Models\Menu;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    private $_view = 'admin.news.';
    private $_attr = News::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new News();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_setting = ['title' => __('datametas.title.news.index'), 'attr' => $this->_attr];

        $search = $request->all();
        $search['relationship'] = ['media'];

        $categories = Category::getList(['menu_route_name' => 'front.news.index']);
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);

        unset($search['relationship']);
        $vars = ['page_setting', 'search', 'data', 'categories'];
        return view($this->_view . 'index', compact($vars));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_setting = ['title' => __('datametas.title.news.create'), 'attr' => $this->_attr];
        $categories = Category::getList(['menu_route_name' => 'front.news.index']);
        return view($this->_view . 'update', compact(['page_setting', 'categories']));
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
//            if ($request->hasFile($this->_attr . '-file')) {
//                $media = new Media();
//                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_NEWS_MEDIA);
//            }

            if ($request->hasFile($this->_attr . '-file-large')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file-large'), $id, Media::OBJ_TYPE_NEWS_MEDIA_DETAIL, ['key' => __('validation.attributes.' . $this->_attr . '-file-large')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file-large' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-carousel')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-carousel'), $id, Media::OBJ_TYPE_NEWS_CAROUSEL, ['key' => __('validation.attributes.' . $this->_attr . '-carousel')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-carousel' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-file-big')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file-big'), $id, Media::OBJ_TYPE_NEWS_MEDIA_BIG, ['key' => __('validation.attributes.' . $this->_attr . '-file-big')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file-big' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-video')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-video'), $id, Media::OBJ_TYPE_NEWS_VIDEO);
            }

            return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.create.success'));
        }

        return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.create.fail'));
    }

    /**
     * Show the information for resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $params = [];
        $params['id'] = $id;

        if (empty($data = $this->_model->filter(1, $params)))
            return redirect()->back()->with('fail', __('custom.msg.error.404'));

        $page_setting = ['title' => __('datametas.title.news.show'), 'attr' => $this->_attr, 'detail' => true];
        return view($this->_view . 'show', compact(['page_setting', 'data']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (empty($data = $this->_model->filter(1, ['id' => $id])))
            return redirect()->back()->with('fail', __('custom.msg.error.404'));

        $lang = \Input::get('lang', env('APP_LOCALE'));
        $categories = Category::getList(['menu_route_name' => 'front.news.index']);
        $page_setting = ['title' => __('datametas.title.news.edit'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['page_setting', 'categories', 'lang', 'data', 'id']));
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
//            if ($request->hasFile($this->_attr . '-file')) {
//                $media = new Media();
//                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_NEWS_MEDIA);
//            }

            if ($request->hasFile($this->_attr . '-file-large')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file-large'), $id, Media::OBJ_TYPE_NEWS_MEDIA_DETAIL, ['key' => __('validation.attributes.' . $this->_attr . '-file-large')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file-large' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-carousel')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-carousel'), $id, Media::OBJ_TYPE_NEWS_CAROUSEL, ['key' => __('validation.attributes.' . $this->_attr . '-carousel')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-carousel' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-file-big')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file-big'), $id, Media::OBJ_TYPE_NEWS_MEDIA_BIG, ['key' => __('validation.attributes.' . $this->_attr . '-file-big')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file-big' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-video')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-video'), $id, Media::OBJ_TYPE_NEWS_VIDEO);
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

        $data->delete();

        Media::removeRecord($id, [
            Media::OBJ_TYPE_NEWS_VIDEO,
            Media::OBJ_TYPE_NEWS_MEDIA,
            Media::OBJ_TYPE_NEWS_CAROUSEL,
            Media::OBJ_TYPE_NEWS_MEDIA_BIG,
            Media::OBJ_TYPE_NEWS_MEDIA_DETAIL,
        ]);

        HashKey::removeRecord($id, HashKey::_OBJ_TYPE_NEWS);
        Datameta::removeRecord($id, Datameta::TYPE_NEWS);

        return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.delete.success'));
    }

    /**
     * Update the specified status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        if (empty($id = $request->input('id')) || empty($data = $this->_model->filter(1, ['id' => $id])))
            return $this->getErrorJson(trans('custom.msg.error.no-data'));

        $data->status = ($data->status == Constant::STATUS_ACTIVE) ? Constant::STATUS_INACTIVE : Constant::STATUS_ACTIVE;
        $data->save();

        return $this->getSuccessJson(trans('custom.msg.update.success'));
    }
}
