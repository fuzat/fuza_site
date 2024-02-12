<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Constant;
use App\Models\CoreValue;
use App\Models\Datameta;
use App\Models\Media;
use Illuminate\Http\Request;

class CoreValueController extends BaseController
{
    private $_view = 'admin.core-values.';
    private $_attr = CoreValue::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new CoreValue();
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->all();
        $categories = Category::getList();
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.core-value.index'), 'attr' => $this->_attr];
        return view($this->_view . 'index', compact(['page_setting', 'categories', 'search', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getList(['not_have' => 'core_value', 'menu_route_name' => 'front.about-us']);
        $page_setting = ['title' => __('datametas.title.core-value.create'), 'attr' => $this->_attr];
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
            if ($request->hasFile($this->_attr . '-avatar')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-avatar'), $id, Media::OBJ_TYPE_CORE_VALUE_AVATAR, ['key' => __('validation.attributes.'. $this->_attr . '-avatar'), 'locale' => $input['locale']]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-avatar' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_CORE_VALUE_FILE, ['key' => __('validation.attributes.'. $this->_attr . '-file'), 'locale' => $input['locale']]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-file-how')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file-how'), $id, Media::OBJ_TYPE_CORE_VALUE_FILE_HOW, ['key' => __('validation.attributes.'. $this->_attr . '-file-how'), 'locale' => $input['locale']]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file-how' => $media['msg']])->withInput($input);
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
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($data))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        $categories = Category::getList(['not_have' => 'core_value', 'menu_route_name' => 'front.about-us', 'except_id' => $data->category_id]);
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.core-value.edit'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['id', 'data', 'lang', 'categories', 'page_setting']));
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
            if ($request->hasFile($this->_attr . '-avatar')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-avatar'), $id, Media::OBJ_TYPE_CORE_VALUE_AVATAR, ['key' => __('validation.attributes.' . $this->_attr . '-avatar'), 'locale' => $input['locale']]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-avatar' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_CORE_VALUE_FILE, ['key' => __('validation.attributes.' . $this->_attr . '-file'), 'locale' => $input['locale']]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-file-how')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file-how'), $id, Media::OBJ_TYPE_CORE_VALUE_FILE_HOW, ['key' => __('validation.attributes.' . $this->_attr . '-file-how'), 'locale' => $input['locale']]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file-how' => $media['msg']])->withInput($input);
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

        Media::removeRecord($data->id, [
            Media::OBJ_TYPE_CORE_VALUE_FILE,
            Media::OBJ_TYPE_CORE_VALUE_AVATAR,
            Media::OBJ_TYPE_CORE_VALUE_FILE_HOW,
        ]);

        Datameta::removeRecord($data->id, Datameta::TYPE_CORE_VALUE);
        $data->delete();

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
        $id = $request->input('id');
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($id) || empty($data))
            return $this->getErrorJson(trans('custom.msg.error.no-data'));

        $data->status = ($data->status == Constant::STATUS_ACTIVE) ? Constant::STATUS_INACTIVE : Constant::STATUS_ACTIVE;
        $data->save();

        return $this->getSuccessJson(trans('custom.msg.update.success'));
    }
}
