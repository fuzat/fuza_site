<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoardDirector;
use App\Models\Constant;
use App\Models\CoreValue;
use App\Models\Datameta;
use App\Models\HashKey;
use App\Models\Media;
use App\Models\Menu;
use App\Models\Milestone;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    private $_view = 'admin.posts.';
    private $_attr = Post::_ATTR;
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = new Post();
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
        $page_setting = ['title' => __('datametas.title.post.index'), 'attr' => $this->_attr];

        $menus = Menu::getList();

        return view($this->_view . 'index', compact(['page_setting', 'search', 'menus', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $board_directors = BoardDirector::getList();
        $core_value = CoreValue::getList();
        $milestones = Milestone::getList();
        $menus = Menu::getList();

        $types = __('datametas.select-box.post-type');
        unset($types[3]);

        $page_setting = ['title' => __('datametas.title.post.create'), 'attr' => $this->_attr];
        return view($this->_view . 'update', compact(['page_setting', 'board_directors', 'core_value', 'milestones', 'menus', 'types']));
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

        if ($input[$this->_attr . '-type'] == Post::_TYPE_CONTACT) {
            $menu_contact_id = new Menu();
            $input[$this->_attr . '-menu'] = optional($menu_contact_id->filter(1, ['slug' => 'contact', 'status' => Constant::STATUS_ACTIVE]))->id;
        }

        if ($validator = $this->_model->validation($input))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input)) {
            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();

                if (isset($input[$this->_attr . '-page']) && !empty($input[$this->_attr . '-page']) && $input[$this->_attr . '-page'] == 'vision-mission')
                    $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_POST_VISION_MISSION, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);
                else
                    $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_POST, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

                if (isset($media['msg']) && !empty($media['msg']))
                    return redirect()->back()->withErrors([$this->_attr . '-file' => $media['msg']])->withInput($input);
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
        $data = $this->_model->filter(1, ['id' => $id]);

        if (empty($data))
            return redirect()->route($this->_view . 'index')->with('fail', __('custom.msg.error.404'));

        $board_directors = BoardDirector::getList();
        $core_value = CoreValue::getList();
        $milestones = Milestone::getList();
        $menus = Menu::getList();

        $types = __('datametas.select-box.post-type');
        unset($types[3]);

        $lang = \Input::get('lang', env('APP_LOCALE'));
        $page_setting = ['title' => __('datametas.title.post.edit'), 'attr' => $this->_attr];

        $vars = ['id', 'data', 'lang', 'menus', 'board_directors', 'core_value', 'milestones', 'page_setting', 'types'];
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

        if ($input[$this->_attr . '-type'] == Post::_TYPE_CONTACT) {
            $menu_contact_id = new Menu();
            $input[$this->_attr . '-menu'] = optional($menu_contact_id->filter(1, ['slug' => 'contact', 'status' => Constant::STATUS_ACTIVE]))->id;
        }

        if ($validator = $this->_model->validation($input, $id))
            return redirect()->back()->withErrors($validator)->withInput($input);

        if ($id = $this->_model->doCreatingOrUpdating($input, $id)) {
            if ($request->hasFile($this->_attr . '-file')) {
                $media = new Media();

                if (isset($input[$this->_attr . '-page']) && !empty($input[$this->_attr . '-page']) && $input[$this->_attr . '-page'] == 'vision-mission')
                    $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_POST_VISION_MISSION, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);
                else
                    $media = $media->handleFile($request->file($this->_attr . '-file'), $id, Media::OBJ_TYPE_POST, ['key' => __('validation.attributes.' . $this->_attr . '-file')]);

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

        $banner_id = optional($data->banner)->id;
        $data->delete();

        if ($banner_id) {
            Media::removeRecord($banner_id, [Media::OBJ_TYPE_BANNER_MOBILE, Media::OBJ_TYPE_BANNER]);
            Datameta::removeRecord($banner_id, Datameta::TYPE_BANNER);
        }

        Media::removeRecord($id, [Media::OBJ_TYPE_POST_VISION_MISSION, Media::OBJ_TYPE_POST]);
        HashKey::removeRecord($id, HashKey::_OBJ_TYPE_POST);
        Datameta::removeRecord($id, Datameta::TYPE_POST);

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

    /**
     * Upload file by summernote editor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'file' => 'required|file|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image),
        ]);

        if ($validator->fails())
            return response(['code' => 201, 'msg' => $validator->message()->first(), 'data' => null]);

        $file = $request->file('file');
        if ($file->isValid()) {
            $extension = $file->getClientOriginalExtension();
            $name = uniqid()."-".microtime(true).rand(10000, 99999).'.'.$extension;
            $public_path = '/uploads/userfiles/posts-content/' . date('YmW').'/';
            $full_path = $public_path . $name;
            $destinationPath = public_path($public_path);
            if (!\File::exists($destinationPath))
                \File::makeDirectory($destinationPath, 0777, true);

            // move original file
            $file->move($destinationPath, $name);

            return response(['code' => 200, 'msg' => '', 'data' => asset($full_path)]);
        }
    }
}
