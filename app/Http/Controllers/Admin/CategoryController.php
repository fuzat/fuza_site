<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Constant;
use App\Models\Menu;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    private $_view = 'admin.categories.';
    private $_attr = Category::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Category();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menus = Menu::getList();
        $search = $request->all();
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.category.index'), 'attr' => $this->_attr];
        return view($this->_view . 'index', compact(['page_setting', 'search', 'menus', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::getList();
        $page_setting = ['title' => __('datametas.title.category.create'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['page_setting', 'menus']));
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

        if ($this->_model->doCreatingOrUpdating($input))
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
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($data))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        $menus = Menu::getList();
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.category.edit'), 'attr' => $this->_attr];

        $vars = ['id', 'data', 'lang', 'menus', 'page_setting'];
        return view($this->_view . 'update', compact($vars));
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

        if ($this->_model->doCreatingOrUpdating($input, $id))
            return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.update.success'));

        return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.update.fail'));
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
