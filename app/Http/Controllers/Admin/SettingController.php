<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    private $_view = 'admin.settings.';
    private $_attr = Setting::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Setting();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $data = $this->_model->newQuery()->where('is_deleting', false)->get();
        $page_setting = ['title' => __('datametas.title.setting.edit'), 'attr' => $this->_attr];
        return view($this->_view . 'edit', compact(['lang', 'data', 'page_setting']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($this->_model->doUpdating($request))
            return redirect()->route($this->_view . 'edit')->with('success', __('custom.msg.update.success'));

        return redirect()->route($this->_view . 'edit')->with('fail', __('custom.msg.update.fail'));
    }
}
