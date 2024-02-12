<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use App\Models\Constant;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 

class MenuController extends BaseController
{
    private $_view = 'admin.menus.';
    private $_attr = Menu::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Menu();
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
        $search['ordering'] = ['editable' => 'desc', 'created_at' => 'desc'];

        $data = $this->_model->filter(Constant::PER_PAGE_DEFAULT, $search);
        unset($search['ordering']);

        $parents = Menu::getList();
        $page_setting = ['title' => __('datametas.title.menu.index'), 'attr' => $this->_attr];

        return view($this->_view . 'index', compact(['page_setting', 'parents', 'search', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Menu::getList(['parent_id_null' => true]);

        $page_setting = ['title' => __('datametas.title.menu.create'), 'attr' => $this->_attr];

        return view($this->_view . 'update', compact(['page_setting', 'parents']));
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

//        if (empty($data->editable))
//            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.not-edit'));

        $parents = Menu::getList(['parent_id_null' => true], $id);
        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.menu.edit'), 'attr' => $this->_attr];

        $vars = ['id', 'data', 'page_setting', 'lang', 'parents'];
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

        if ($data = $this->_model->filter(1, ['id' => $id])) {
            if (($data->children->count()) && !empty($request->input('parent_id')))
                return redirect()->back()->withErrors(['parent_id' => 'Bạn không thể chọn danh mục cha'])->withInput($input);

            if ($this->_model->doCreatingOrUpdating($input, $id))
                return redirect()->route($this->_view . 'index')->with('success', __('custom.msg.update.success'));

            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.update.fail'));
        }

        return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));
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

    /**
     * Show the form for sorting the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        $page_setting = ['title' => __('datametas.title.menu.sorting'), 'attr' => $this->_attr];

        $sort = $request->input('sort', -1);
        $type = $request->input('type', 'menu');

        if ($sort == -1) {
            $data = $this->_model->filter(0, ['ordering' => ['sorting' => 'asc'], 'parent_id_null' => true], ['id']);
        } else {
            if (in_array($type, ['menu', 'post'])) {
                $data = new Post();
                $data = $data->filter(0, ['ordering' => ['sorting' => 'asc'], 'status' => Constant::STATUS_ACTIVE, 'menu' => $sort], ['id']);
            }

            if ($type == 'business') {
                $data = new Business();
                $data = $data->filter(0, ['ordering' => ['sorting' => 'asc'], 'status' => Constant::STATUS_ACTIVE], ['id']);
            }
        }

        return view($this->_view . 'sorting', compact(['data', 'sort', 'type', 'page_setting']));
    }

    /**
     * Update the specified sorting in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSorting(Request $request)
    {
        $arr_id = $request->input('id');
        $sort = $request->input('sort', -1);
        $type = $request->input('type', 'menu');

        if (empty($arr_id))
            return $this->getErrorJson(trans('custom.msg.error.404'));

        if ($sort == -1) {
            foreach ($arr_id as $key => $id)
                $this->_model->newQuery()->where('id', $id)->update(['sorting' => ($key + 1)]);
        } else {
            if (in_array($type, ['menu', 'post'])) {
                foreach ($arr_id as $key => $id) {
                    Post::query()->where('id', $id)->update(['sorting' => ($key + 1)]);
                }
            }

            if ($type == 'business') {
                foreach ($arr_id as $key => $id) {
                    Business::query()->where('id', $id)->update(['sorting' => ($key + 1)]);
                }
            }
        }

        return response()->json(['code' => 200, 'msg' => __('custom.msg.change-status.success'), 'data' => null]);
    }
}
