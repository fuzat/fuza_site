<?php

namespace App\Http\Controllers\Admin;

use App\Models\Constant;
use App\Models\Datameta;
use App\Models\Media;
use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends BaseController
{
    private $_view = 'admin.milestones.';
    private $_attr = Milestone::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Milestone();
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
        $search['relationship'] = ['media'];

        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.milestone.index'), 'attr' => $this->_attr];

        unset($search['relationship']);
        $vars = ['page_setting', 'search', 'data'];

        return view($this->_view . 'index', compact($vars));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_setting = ['title' => __('datametas.title.milestone.create'), 'attr' => $this->_attr];

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
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_MILESTONES, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
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
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $data = $this->_model->filter(1, ['id' => $id]);
        $page_setting = ['title' => __('datametas.title.milestone.edit'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['page_setting', 'lang', 'data', 'id']));
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
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_MILESTONES, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
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

        Datameta::removeRecord($data->id, Datameta::TYPE_MILESTONE);
        Media::removeRecord($data->id, Media::OBJ_TYPE_MILESTONES);
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
