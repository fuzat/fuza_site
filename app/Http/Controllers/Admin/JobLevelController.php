<?php

namespace App\Http\Controllers\Admin;

use App\Models\Constant;
use App\Models\Datameta;
use App\Models\JobLevel;
use Illuminate\Http\Request;

class JobLevelController extends BaseController
{
    private $_model = null;
    private $_attr = JobLevel::_ATTR;
    private $_view = 'admin.job-levels.';

    public function __construct()
    {
        parent::__construct();
        $this->_model = new JobLevel();
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
        $page_setting = ['title' => __('datametas.title.job-level.index'), 'attr' => $this->_attr];

        return view($this->_view . 'index', compact(['page_setting', 'search', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_setting = ['title' => __('datametas.title.job-level.create'), 'attr' => $this->_attr];
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

        if ($id = $this->_model->doCreatingOrUpdating($input))
            return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.create.success'));

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

        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.job-level.edit'), 'attr' => $this->_attr];

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

        if ($id = $this->_model->doCreatingOrUpdating($input, $id))
            return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.update.success'));

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
            $data->jobs()->update(['level_id' => null]);
        } catch (\Exception $exception) {
            return redirect()->route($this->_view . 'index')->with('fail', $exception->getMessage());
        }

        Datameta::removeRecord($data->id, Datameta::TYPE_JOB_LEVEL);
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
