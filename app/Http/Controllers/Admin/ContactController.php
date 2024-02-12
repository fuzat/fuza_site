<?php

namespace App\Http\Controllers\Admin;

use App\Models\Constant;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    private $_view = 'admin.contact.';
    private $_attr = Contact::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Contact();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_setting = ['title' => __('datametas.title.contact.index'), 'attr' => $this->_attr];

        $search = $request->all();
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);

        $vars = ['data', 'search', 'page_setting'];
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
     * Change contact's column status value.
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
