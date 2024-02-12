<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\Constant;
use App\Models\Datameta;
use App\Models\HashKey;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobLevel;
use App\Models\JobType;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Http\Request;

class JobController extends BaseController
{
    private $_view = 'admin.jobs.';
    private $_attr = Job::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Job();
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
        $search['relationship'] = ['media', 'company', 'locations', 'industries'];

        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.job.index'), 'attr' => $this->_attr];

        $companies = Company::getList();
        $locations = Location::getList();
        $industries = Industry::getList();
        $job_types = JobType::getList();
        $job_levels = JobLevel::getList();

        unset($search['relationship']);
        return view($this->_view . 'index', compact(['page_setting', 'companies', 'locations', 'industries', 'job_levels', 'job_types', 'search', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = [];
        $companies = Company::getList();
        $industries = Industry::getList();
        $job_types = JobType::getList();
        $job_levels = JobLevel::getList();

        $page_setting = ['title' => __('datametas.title.job.create'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['page_setting', 'industries', 'locations', 'companies', 'job_levels', 'job_types']));
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
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_JOB, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
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

        $page_setting = ['title' => __('datametas.title.job.show'), 'attr' => $this->_attr, 'detail' => true];
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
        if (!$data = $this->_model->filter(1, ['id' => $id]))
            return redirect()->route($this->_view.'index')->with('fail', __('custom.msg.error.404'));

        $companies = Company::getList();
        $industries = Industry::getList();
        $job_types = JobType::getList();
        $job_levels = JobLevel::getList();
        $locations = CompanyLocation::getList(['company' => $data->company_id]);

        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.job.edit'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['id', 'data', 'lang', 'companies', 'locations', 'industries', 'page_setting', 'job_levels', 'job_types']));
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
                $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_JOB, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

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

        try {
            $data->industries()->detach();
            $data->locations()->detach();
            $data->delete();
        } catch (\Exception $exception) {
            return redirect()->route($this->_view . 'index')->with('fail', $exception->getMessage());
        }

        HashKey::removeRecord($id, HashKey::_OBJ_TYPE_JOB);
        Datameta::removeRecord($id, Datameta::TYPE_JOB);
        Media::removeRecord($id, Media::OBJ_TYPE_JOB);

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
