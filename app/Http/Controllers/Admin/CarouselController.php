<?php

namespace App\Http\Controllers\Admin;

use App\Models\Carousel;
use App\Models\Category;
use App\Models\Constant;
use App\Models\Datameta;
use Illuminate\Http\Request;

class CarouselController extends BaseController
{
    private $_view = 'admin.carousels.';
    private $_attr = Carousel::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Carousel();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::getList(['menu_route_name' => 'front.about-us']);
        $search = $request->all();
        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        $page_setting = ['title' => __('datametas.title.carousel.index'), 'attr' => $this->_attr];
        return view($this->_view . 'index', compact(['page_setting', 'categories', 'search', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getList(['menu_route_name' => 'front.about-us']);
        $page_setting = ['title' => __('datametas.title.carousel.create'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['page_setting', 'categories']));
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

        $categories = Category::getList(['menu_route_name' => 'front.about-us']);
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.carousel.edit'), 'attr' => $this->_attr];

        $vars = ['id', 'data', 'lang', 'categories', 'page_setting'];
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$data = $this->_model->filter(1, ['id' => $id]))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        Datameta::removeRecord($data->id, Datameta::TYPE_CAROUSEL);
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
