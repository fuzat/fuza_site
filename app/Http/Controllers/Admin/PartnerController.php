<?php

namespace App\Http\Controllers\Admin;

use App\Models\Constant;
use App\Models\Media;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends BaseController
{
    private $_view = 'admin.partners.';
    private $_attr = Partner::_ATTR;
    private $_model;


    public function __construct()
    {
        parent::__construct();
        $this->_model = new Partner();
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
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.partner.index'), 'attr' => $this->_attr];
        return view($this->_view . 'index', compact(['data', 'search', 'page_setting']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_setting = ['title' => __('datametas.title.partner.create'), 'attr' => $this->_attr];
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
            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_PARTNER, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
            }

            return redirect()->route($this->_view.'index')->with('success', __('custom.msg.create.success'));
        }

        return redirect()->route($this->_view.'index')->with('fail', __('custom.msg.create.fail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_setting = ['title' => __('datametas.title.partner.edit'), 'attr' => $this->_attr];

        if (!$data = $this->_model->filter(1, ['id' => $id]))
            return redirect()->route($this->_view.'index')->with('fail', __('custom.msg.error.404'));

        return view($this->_view . 'update', compact(['id', 'data', 'page_setting']));
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
            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_PARTNER, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
            }

            return redirect()->route($this->_view.'index')->with('success', __('custom.msg.update.success'));
        }

        return redirect()->route($this->_view.'index')->with('fail', __('custom.msg.update.fail'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->_model->filter(1, ['id' => $id]);

        if($data->delete()) {
            Media::removeRecord($id, Media::OBJ_TYPE_PARTNER);
            return redirect()->back()->with("success", __('custom.msg.delete.success'));
        }

        return redirect()->back()->with("fail", __('custom.msg.delete.fail'));
    }

    /**
     * Change partner's column status value.
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
