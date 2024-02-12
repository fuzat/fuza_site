<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\Constant;
use App\Models\Industry;
use App\Models\Job;
use App\Models\Location;
use App\Models\MailBox;
use App\Models\Media;
use App\Models\Menu;
use App\Models\HashKey;
use Illuminate\Http\Request;

class CareerController extends BaseController
{
    private $_view = 'front.careers.';

    public function index(Request $request)
    {
        $active = Constant::STATUS_ACTIVE;

        $params = $request->all();
        $params['status'] = $active;
        $params['expired'] = date('Y-m-d');
        $params['relationship'] = ['media', 'locations'];

        $data = new Job();
        $data = $data->filter(6, $params);

        $menu = new Menu();
        $menu = $menu->filter(1, ['route_name' => 'front.jobs.index', 'status' => $active]);

        $banner = null;
        if (!empty($menu)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'position'  => BannerPosition::_PAGE_POST,
                'status'    => $active,
                'menu'      => $menu->id,
            ]);

            $poster = new Banner();
            $poster = $poster->filter(1, [
                'position'  => BannerPosition::_PAGE_CAREER,
                'status'    => $active,
                'menu'      => $menu->id,
            ]);
        }

        $companies = Company::getList(['has_relation' => 'jobs']);
        $industries = Industry::getList(['has_relation' => 'jobs']);
        $locations = Location::getList();

        $page_setting = ['title' => __('datametas.web.title.all-jobs')];
        unset($params['deadline_apply'], $params['relationship'], $params['status'], $menu);
        $vars = ['page_setting', 'industries', 'locations', 'companies', 'banner', 'data', 'params', 'poster'];
        return view($this->_view . 'index', compact($vars));
    }

    public function show($slug, $hash_key)
    {
        $active = Constant::STATUS_ACTIVE;

        $params['status'] = $active;
        $params['relationship'] = ['company.work_locations', 'industries'];
        $params['id'] = optional(HashKey::getData(HashKey::_OBJ_TYPE_JOB, $hash_key))->obj_id;

        $data = new Job();
        $data = $data->filter(1, $params);

        if (empty($data))
            return abort(404);

        $menu = new Menu();
        $menu = $menu->filter(1, ['route_name' => 'front.jobs.index', 'status' => $active]);

        $banner = null;
        if (!empty($menu)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'position'  => BannerPosition::_PAGE_POST,
                'status'    => $active,
                'menu'      => $menu->id,
            ]);
        }

        $similar_jobs = new Job();
        $similar_jobs = $similar_jobs->filter(0, [
            'status'        => $active,
            'not_id'        => $params['id'],
            'expired'       => date('Y-m-d'),
            'limit'         => Constant::PER_PAGE_6,
            'relationship'  => ['media', 'locations'],
        ]);

        $seo = [
            'title'         => optional($data->datameta('', 'name'))->data_value,
            'description'   => strip_tags(optional($data->datameta('', 'description'))->data_value),
            'image'         => !empty($data->media) ? asset($data->media->web_path) : null,
        ];

        $page_setting = ['title' => optional($data->datameta('', 'name'))->data_value];

        $vars = ['page_setting', 'similar_jobs', 'banner', 'data', 'seo'];

        return view($this->_view . 'show', compact($vars));
    }

    public function getJoinTalentCommunity(Request $request)
    {
        $active = Constant::STATUS_ACTIVE;

        $menu = new Menu();
        $menu = $menu->filter(1, ['route_name' => 'front.jobs.index', 'status' => $active]);

        $banner = null;
        if (!empty($menu)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'position'  => BannerPosition::_PAGE_POST,
                'status'    => $active,
                'menu'      => Menu::_MENU_JOIN_TALENT_COMMUNITY_VAL,
            ]);
        }

        $companies = Company::getList();
        $page_setting = ['title' => __('datametas.web.title.join-talent-community')];

        $params = $request->all();
        $vars = ['page_setting', 'companies', 'banner', 'params'];
        return view($this->_view . 'community', compact($vars));
    }

    public function postJoinTalentCommunity(Request $request)
    {
        $input = $request->all();
        $input['sendEmail'] = true;

        $attr = Application::_ATTR . '-';

        $application = new Application();

        if ($validator = $application->validation($input))
            return $this->getErrorJson($validator->errors()->first());

        if ($request->hasFile($attr . 'cv_file')) {
            $uploaded = Media::uploadFileOnly($request->file($attr . 'cv_file'), Media::OBJ_TYPE_APPLICANT_CV);
            $input['url'] = (!empty($uploaded) && isset($uploaded['url'])) ? $uploaded['url'] : null;
        }

        $job = new Job();
        $job = $job->filter(1, ['id' => $input[$attr . 'position']], ['id']);

        $input[$attr . 'job'] = optional($job)->id;
        $input[$attr . 'position'] = optional($job->datameta('', 'name'))->data_value;

        if (empty($application = $application->doCreatingOrUpdating($input)))
            return $this->getErrorJson(trans('custom.msg.send-applicant.fail'));

        $email_to = optional($application->company)->email;

        MailBox::doCreate([
            'object_id' => $application->id,
            'name'      => $application->name,
            'email'     => $application->email,
            'file'      => $application->cv_file,
            'subject'   => MailBox::_MAIL_SUBJECT[MailBox::_TYPE_APPLICATION_INFORM] . $application->position,
            'type'      => MailBox::_TYPE_APPLICATION_INFORM,
            'content'   => [
                'name'          => $application->name,
                'applicant_id'  => $application->id,
                'slug'      => !empty($job) ? str_slug(optional($job->datameta('', 'name'))->data_value) : '404-not-found',
                'hash_key' => !empty($job->hash_key) ? optional($job->hash_key)->code : '404-not-found',
            ],
        ], 'user');

        if (isset($email_to) && !empty($email_to)) {
            MailBox::doCreate([
                'object_id' => $application->id,
                'name'      => $application->name,
                'email'     => $application->email,
                'file'      => $application->cv_file,
                'subject'   => MailBox::_MAIL_SUBJECT[MailBox::_TYPE_APPLICATION] . $application->position,
                'type'      => MailBox::_TYPE_APPLICATION,
                'content'   => [
                    'applicant_id'  => $application->id,
                    'name'          => $application->name,
                    'position'      => $application->position,
                ],
                'email_to_system' => $email_to,
            ]);
        }

        return $this->getSuccessJson(trans('custom.msg.send-applicant.success'));
    }

    public function getCompanyLocation(Request $request)
    {
        if (!$request->has('company_id'))
            return $this->getErrorJson(trans('custom.msg.error.no-data'));

        $data = !empty($request->input('company_id')) ? CompanyLocation::getList(['company' => $request->input('company_id')]) : [];

       return $this->getSuccessJson('', $data);
    }

    public function ajaxGetJob(Request $request)
    {
        if (!$request->has('company_id'))
            return $this->getErrorJson(trans('custom.msg.error.no-data'));

        $expired = $request->input('expired');
        $company_id = $request->input('company_id');
        $data = !empty($company_id) ? Job::getList(['expired' => empty($expired) ? date('Y-m-d') : null, 'company' => $company_id]) : [];

        return $this->getSuccessJson('', $data);
    }
}
