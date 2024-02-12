<?php

namespace App\Http\Controllers\Admin;

use App\Models\Constant;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends BaseController
{
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Language();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, ['ordering' => ['created_at' => 'asc']]);
        $page_setting = ['title' => __('datametas.title.language.index')];
        return view('admin.languages.index', compact(['page_setting', 'data']));
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
