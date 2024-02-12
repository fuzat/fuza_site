<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Constant;
use App\Models\Contact;
use App\Models\Industry;
use App\Models\MailBox;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page_setting = ['title' => __('datametas.web.title.contact')];
        $active = Constant::STATUS_ACTIVE;

        $menu_id = new Menu();
        $menu_id = optional($menu_id->filter(1, ['route_name' => 'front.contact', 'status' => $active]))->id;

        $banner = null;
        if (!empty($menu_id)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'relationship'  => ['media', 'media_mobile'],
                'position'      => BannerPosition::_PAGE_POST,
                'status'        => $active,
                'menu'          => $menu_id,
            ]);
        }

        $post = new Post();
        $post = $post->filter(1, ['menu' => $menu_id, 'status' => $active]);

        $industries = Industry::getList();

        $vars = ['post', 'banner', 'page_setting', 'industries', 'menu_id'];
        return view('front.contact', compact($vars));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $_model = new Contact();

        if (!empty($validation = $_model->validation($input)))
            return $this->getErrorJson($validation->errors()->first());

        $_model = $_model->newQuery()->create([
            'fullname'      => $input['fullname'],
            'phone'         => $input['phone'],
            'email'         => $input['email'],
            'subject'       => $input['subject'],
            'content'       => $input['message'],
            'industry_id'   => $input['industry'],
        ]);

        if (empty($_model))
            return $this->getErrorJson(trans('custom.msg.send-msg.fail'));

        MailBox::doCreate([
            "object_id" => $_model->id,
            "email"     => $_model->email,
            "name"      => $_model->fullname,
            "type"      => MailBox::_TYPE_CONTACT,
            "subject"   => MailBox::_MAIL_SUBJECT[MailBox::_TYPE_CONTACT],
            "content"   => [
                "name_to"   => MailBox::_system_name,
                'name_from' => $_model->fullname,
                'content'   => $_model->content,
                'phone'     => $_model->phone,
                "sender"    => $_model->email,
            ],
        ]);

        return $this->getSuccessJson(trans('custom.msg.send-msg.success'));
    }

}
