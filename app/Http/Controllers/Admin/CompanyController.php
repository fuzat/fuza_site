<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\Constant;
use App\Models\Datameta;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    private $_view = 'admin.companies.';
    private $_attr = Company::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Company();
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
        $search['relationship'] = ['media'];

        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.company.index'), 'attr' => $this->_attr];

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
        $locations = Location::getList();
        $page_setting = ['title' => __('datametas.title.company.create'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['page_setting', 'locations']));
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
            if ($request->hasFile($this->_attr . '-logo')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-logo'), $id, Media::OBJ_TYPE_COMPANY);
            }

            $company_location = new CompanyLocation();

            for ($i = 0; $i < count($input[$this->_attr . '-city']); $i++) {
                $location = Location::query()->find($input[$this->_attr . '-city'][$i]);

                $company_location->doCreatingOrUpdating([
                    'company_id'    => $id,
                    'location_id'   => $location->id,
                    'address'       => $input[$this->_attr . '-address'][$i],
                    'locale'        => \LaravelLocalization::getCurrentLocale(),
                    'city'          => optional($location->datameta('', 'name'))->data_value,
                ]);
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
        if (empty($data = $this->_model->filter(1, ['id' => $id])))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        $locations = Location::getList();
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.company.edit'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['id', 'data', 'lang', 'page_setting', 'locations']));
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
            if ($request->hasFile($this->_attr . '-logo')) {
                $media = new Media();
                $media->handleFile($request->file($this->_attr . '-logo'), $id, Media::OBJ_TYPE_COMPANY);
            }

            $company_location = new CompanyLocation();
            $work_locations = new CompanyLocation();
            $work_locations = $work_locations->filter(0, ['company' => $id])->pluck('id')->toArray();

            if (count($work_locations)) {
                Datameta::removeRecord($work_locations, Datameta::TYPE_COMPANY_LOCATION, '%_' . $input['locale']);

                $arr = [];
                foreach ($input[$this->_attr . '-city'] as $key => $value) {
                    $arr['city'][] = $value;
                    $arr['address'][] = $input[$this->_attr . '-address'][$key];
                }

                for ($i = 0; $i < count($arr['city']); $i++) {
                    $location = Location::query()->find($arr['city'][$i]);
                    $company_location->doCreatingOrUpdating([
                        'company_id'    => $id,
                        'location_id'   => $location->id,
                        'locale'        => $input['locale'],
                        'address'       => $arr['address'][$i],
                        'city'          => optional($location->datameta('', 'name'))->data_value,
                    ], isset($work_locations[$i]) ? $work_locations[$i] : null);
                }
            } else {
                for ($i = 0; $i < count($input[$this->_attr . '-city']); $i++) {
                    $location = Location::query()->find($input[$this->_attr . '-city'][$i]);
                    $company_location->doCreatingOrUpdating([
                        'company_id'    => $id,
                        'location_id'   => $location->id,
                        'locale'        => $input['locale'],
                        'address'       => $input[$this->_attr . '-address'][$i],
                        'city'          => optional($location->datameta('', 'name'))->data_value,
                    ]);
                }
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
        if (!$data = $this->_model->filter(1, ['relationship' => ['jobs', 'media', 'work_locations'], 'id' => $id]))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        try {
            foreach ($data->work_locations as $work_location) {
                $work_location->jobs()->detach();
            }

            $data->work_locations()->delete();
            $data->jobs()->delete();
        } catch (\Exception $exception) {
            return redirect()->route($this->_view . 'index')->with('fail', $exception->getMessage());
        }

        Datameta::removeRecord($data->id, Datameta::TYPE_COMPANY);
        Media::removeRecord($data->id, Media::OBJ_TYPE_COMPANY);
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
