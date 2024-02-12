<?php

namespace App\Http\Controllers\Admin;

use App\Models\Application;
use App\Models\Company;
use App\Models\Constant;
use App\Models\JobLevel;
use App\Models\JobType;
use Illuminate\Http\Request;


class ApplicationController extends BaseController
{
    private $_view = 'admin.applications.';
    private $_attr = Application::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Application();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_setting = ['title' => __('datametas.title.application.index'), 'attr' => $this->_attr];

        $companies = Company::getList(['has_relation' => 'jobs']);
        $job_types = JobType::getList();
        $job_levels = JobLevel::getList();

        $search = $request->all();
        $search['relationship'] = ['company', 'company_location'];
        $search['ordering'] = ['status' => 'asc', 'created_at' => 'desc'];
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);

        unset($search['relationship'], $search['ordering']);
        $vars = ['search', 'page_setting', 'data', 'companies', 'job_types', 'job_levels'];
        return view($this->_view . 'index', compact($vars));
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
        return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.delete.success'));
    }

    /**
     * Change application's column status value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        if ($data = $this->_model->filter(1, ['id' => $id])) {
            $data->status = $status;
            $data->save();
            return $this->getSuccessJson(trans('custom.msg.update.success'));
        }

        return $this->getErrorJson(trans('custom.msg.error.404'));
    }
}
