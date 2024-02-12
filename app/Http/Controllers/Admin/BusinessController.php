<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use App\Models\Constant;
use App\Models\Datameta;
use App\Models\HashKey;
use App\Models\Media;
use Illuminate\Http\Request;

class BusinessController extends BaseController
{
    private $_view = 'admin.businesses.';
    private $_attr = Business::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Business();
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
        $search['relationship'] = ['avatar', 'file', 'icon', 'file_home'];
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.business.index'), 'attr' => $this->_attr];

        unset($search['relationship']);
        return view($this->_view . 'index', compact(['page_setting', 'search', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_setting = ['title' => __('datametas.title.business.index'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['page_setting']));
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
                $media->handleFile($request->file($this->_attr . '-avatar'), $id, Media::OBJ_TYPE_BUSINESS_AVATAR);
            }

            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_BUSINESS_IMAGE);
            }

            if ($input[$this->_attr . '-show-home'] == Constant::STATUS_ACTIVE) {
                if ($request->hasFile($this->_attr . '-icon')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-icon'), $id, Media::OBJ_TYPE_BUSINESS_ICON);
                }

                if ($request->hasFile($this->_attr . '-icon-act')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-icon-act'), $id, Media::OBJ_TYPE_BUSINESS_ICON_ACT);
                }

                if ($request->hasFile($this->_attr . '-file-home')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-file-home'), $id, Media::OBJ_TYPE_BUSINESS_IMAGE_HOME);
                }

                if ($request->hasFile($this->_attr . '-products-background')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-products-background'), $id, Media::OBJ_TYPE_BUSINESS_PRODUCTS_BACKGROUND);
                }
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

        $page_setting = ['title' => __('datametas.title.business.show'), 'attr' => $this->_attr, 'detail' => true];
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
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($data))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.business.edit'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['id', 'data', 'lang', 'page_setting']));
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
                $media->handleFile($request->file($this->_attr . '-avatar'), $id, Media::OBJ_TYPE_BUSINESS_AVATAR);
            }

            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_BUSINESS_IMAGE);
            }

            if ($input[$this->_attr . '-show-home'] == Constant::STATUS_ACTIVE) {
                if ($request->hasFile($this->_attr . '-icon')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-icon'), $id, Media::OBJ_TYPE_BUSINESS_ICON);
                }

                if ($request->hasFile($this->_attr . '-icon-act')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-icon-act'), $id, Media::OBJ_TYPE_BUSINESS_ICON_ACT);
                }

                if ($request->hasFile($this->_attr . '-file-home')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-file-home'), $id, Media::OBJ_TYPE_BUSINESS_IMAGE_HOME);
                }

                if ($request->hasFile($this->_attr . '-products-background')) {
                    $media = new Media();
                    $media->handleFile($request->file($this->_attr . '-products-background'), $id, Media::OBJ_TYPE_BUSINESS_PRODUCTS_BACKGROUND);
                }
            } else {
                Media::removeRecord($id, Media::OBJ_TYPE_BUSINESS_ICON);
                Media::removeRecord($id, Media::OBJ_TYPE_BUSINESS_IMAGE_HOME);
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
            Media::OBJ_TYPE_BUSINESS_ICON,
            Media::OBJ_TYPE_BUSINESS_IMAGE,
            Media::OBJ_TYPE_BUSINESS_AVATAR,
            Media::OBJ_TYPE_BUSINESS_ICON_ACT,
            Media::OBJ_TYPE_BUSINESS_IMAGE_HOME,
        ]);

        Datameta::removeRecord($id, Datameta::TYPE_BUSINESS);
        HashKey::removeRecord($id, HashKey::_OBJ_TYPE_BUSINESS);

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
