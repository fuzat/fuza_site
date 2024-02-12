<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoardDirector;
use App\Models\Constant;
use App\Models\Datameta;
use App\Models\Media;
use App\Models\Position;
use Illuminate\Http\Request;

class BoardDirectorController extends BaseController
{
    private $_view = 'admin.board-directors.';
    private $_attr = BoardDirector::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new BoardDirector();
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
        $positions = Position::getList();
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.board-director.index'), 'attr' => $this->_attr];
        return view($this->_view . 'index', compact(['page_setting', 'positions', 'search', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::getList();
        $page_setting = ['title' => __('datametas.title.board-director.create'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['page_setting', 'positions']));
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
        $input['sorting'] = str_replace(',', '', isset($input['sorting']) ? $input['sorting'] : 0);

        if ($input['on_top'] != Constant::STATUS_ACTIVE)
            $input[$this->_attr . '-description-2' ]   = null;

        if ($validator = $this->_model->validation($input))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input)) {
            if ($request->hasFile($this->_attr . '-avatar')) {
                Media::removeRecord($id, [Media::OBJ_TYPE_DIRECTOR_AVATAR_BIG, Media::OBJ_TYPE_DIRECTOR_AVATAR]);

                $media = new Media();
                $media_type = ($input['on_top'] == Constant::STATUS_ACTIVE) ? Media::OBJ_TYPE_DIRECTOR_AVATAR_BIG : Media::OBJ_TYPE_DIRECTOR_AVATAR;
                $media = $media->handleFile($request->file($this->_attr . '-avatar'), $id, $media_type, ['key' => __('validation.attributes.' . $this->_attr . '-avatar')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-avatar' => $media['msg']])->withInput($input);
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

        $positions = Position::getList();
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.board-director.edit'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['id', 'data', 'lang', 'positions', 'page_setting']));
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

        $data = $this->_model->filter(1, ['id' => $id]);

        $input[$this->_attr . '-position'] = isset($input[$this->_attr . '-position']) ? $input[$this->_attr . '-position'] : $data->positions()->get(['id'])->pluck('id')->toArray();
        $input['on_top'] = isset($input['on_top']) ? $input['on_top'] : $data->on_top;
        $input['sorting'] = str_replace(',', '', isset($input['sorting']) ? $input['sorting'] : $data->sorting);

        if ($input['on_top'] != Constant::STATUS_ACTIVE)
            $input[$this->_attr . '-description-2'] = null;

        if ($validator = $this->_model->validation($input, $id))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input, $id)) {
            if ($request->hasFile($this->_attr . '-avatar')) {
                Media::removeRecord($id, [Media::OBJ_TYPE_DIRECTOR_AVATAR_BIG, Media::OBJ_TYPE_DIRECTOR_AVATAR]);

                $media = new Media();
                $media_type = ($input['on_top'] == Constant::STATUS_ACTIVE) ? Media::OBJ_TYPE_DIRECTOR_AVATAR_BIG : Media::OBJ_TYPE_DIRECTOR_AVATAR;
                $media = $media->handleFile($request->file($this->_attr . '-avatar'), $id, $media_type, ['key' => __('validation.attributes.' . $this->_attr . '-avatar')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-avatar' => $media['msg']])->withInput($input);
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

        try {
            $data->positions()->detach();
        } catch (\Exception $exception) {
            return redirect()->route($this->_view . 'index')->with('success', $exception->getMessage());
        }

        Media::removeRecord($data->id, [
            Media::OBJ_TYPE_DIRECTOR_AVATAR,
            Media::OBJ_TYPE_DIRECTOR_AVATAR_BIG,
        ]);
        Datameta::removeRecord($data->id, Datameta::TYPE_BOARD_DIRECTOR);
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
}
