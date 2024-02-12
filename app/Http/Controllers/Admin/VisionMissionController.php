<?php

namespace App\Http\Controllers\Admin;

use App\Models\Constant;
use App\Models\Datameta;
use App\Models\Media;
use App\Models\VisionMission;
use Illuminate\Http\Request;

class VisionMissionController extends BaseController
{
    private $_view = 'admin.vision-mission.';
    private $_attr = VisionMission::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();

        $this->_model = new VisionMission();
    }

    public function index(Request $request)
    {
        $search = $request->all();
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.vision-mission.index'), 'attr' => $this->_attr];
        return view($this->_view . 'index', compact(['page_setting', 'search', 'data']));
    }

    public function create()
    {
        $page_setting = ['title' => __('datametas.title.vision-mission.create'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['page_setting']));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if ($validator = $this->_model->validation($input))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input)) {
            if ($request->hasFile($this->_attr . '-icon_active')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-icon_active'), $id, Media::OBJ_TYPE_VISION_MISSION_ACTIVE, ['key' => __('validation.attributes.'. $this->_attr . '-icon_active')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-icon_active' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-icon_inactive')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-icon_inactive'), $id, Media::OBJ_TYPE_VISION_MISSION_INACTIVE, ['key' => __('validation.attributes.'. $this->_attr . '-icon_inactive')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-icon_inactive' => $media['msg']])->withInput($input);
            }

            return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.create.success'));
        }

        return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.create.fail'));
    }

    public function edit($id)
    {
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($data))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.vision-mission.edit'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['id', 'data', 'lang', 'page_setting']));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        if ($validator = $this->_model->validation($input, $id))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input, $id)) {
            if ($request->hasFile($this->_attr . '-icon_active')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-icon_active'), $id, Media::OBJ_TYPE_VISION_MISSION_ACTIVE, ['key' => __('validation.attributes.'. $this->_attr . '-icon_active')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-icon_active' => $media['msg']])->withInput($input);
            }

            if ($request->hasFile($this->_attr . '-icon_inactive')) {
                $media = new Media();
                $media = $media->handleFile($request->file($this->_attr . '-icon_inactive'), $id, Media::OBJ_TYPE_VISION_MISSION_INACTIVE, ['key' => __('validation.attributes.'. $this->_attr . '-icon_inactive')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-icon_inactive' => $media['msg']])->withInput($input);
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

        Media::removeRecord($id, [Media::OBJ_TYPE_VISION_MISSION_ACTIVE, Media::OBJ_TYPE_VISION_MISSION_INACTIVE]);
        Datameta::removeRecord($id, Datameta::TYPE_VISION_MISSION);
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
