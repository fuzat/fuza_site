<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Models\BoardDirector;
use App\Models\Carousel;
use App\Models\Category;
use App\Models\Constant;
use App\Models\CoreValue;
use App\Models\Milestone;
use App\Models\Post;
use App\Models\HashKey;
use App\Models\VisionMission;

class AboutUsController extends BaseController
{
    private $_view = 'front.about-us.';

    public function index($slug, $hash_key)
    {
        $id = optional(HashKey::getData(HashKey::_OBJ_TYPE_POST, $hash_key))->obj_id;
        $active = Constant::STATUS_ACTIVE;

        $post = new Post();
        $post = $post->filter(1, [
            'ordering'  => ['created_at' => 'asc'],
            'type'      => Post::_TYPE_POST,
            'status'    => $active,
            'slug'      => $slug,
            'id'        => $id,
        ]);

        if (empty($id) || empty($post))
            abort(404);

        $banner = null;

        if (!empty($post->banner)) {
            $banner = $post->banner()->where('status', $active)->first();
        }

        if (empty($banner)) {
            $banner = new Banner();
            $banner = $banner->filter(1, [
                'position'      => BannerPosition::_PAGE_POST,
                'relationship'  => ['media', 'media_mobile'],
                'menu'          => $post->menu_id,
                'status'        => $active,
            ]);
        }

        $blade = '';

        $page_setting = ['title' => optional($post->datameta('', 'title'))->data_value];

        switch ($post->page) {
            case 'board-director':

                $data = $this->getBoardOfDirectors();
                $blade = $this->_view . 'board-of-directors';

                break;

            case 'milestone':

                $data = $this->getMilestones();
                $blade = $this->_view . 'milestones';

                break;

            case 'core-value':

                $data = $this->getCoreValue($post->menu->id);
                $blade = $this->_view . 'core-value';

                break;

            case 'vision-mission':

                $data = $this->getVisionMission();
                $blade = $this->_view . 'vision-mision';

                break;

            default:

                $data = $this->getPost($post->id);

                if (str_contains($slug,['compliance', 'policy', 'compliance-policy']))
                    $blade = $this->_view . 'compliance-policy';
                else if (str_contains($slug,['subsidiaries', 'asscociates', 'subsidiaries-asscociates']))
                    $blade = $this->_view . 'subsidiaries-asscociates';
                else
                    $blade = $this->_view . 'others';

                if (empty($blade))
                    abort(404);

                break;
        }

        $seo = [
            'title'         => optional($post->datameta('', 'seo_title'))->data_value,
            'description'   => optional($post->datameta('', 'seo_description'))->data_value,
            'image'         => null,
        ];

        $post_id = $post->id;
        return view($blade, compact(['data', 'banner', 'page_setting', 'post', 'post_id', 'seo']));
    }

    private function getPost($id)
    {
        $data = new Post();
        $data = $data->filter(1, [
            'id'        => $id,
            'status'    => Constant::STATUS_ACTIVE,
        ]);

        return $data;
    }

    private function getVisionMission()
    {
        $data = new VisionMission();
        $data = $data->filter(0, [
            'relationship'  => ['icon_active', 'icon_inactive'],
            'ordering'      => ['created_at' => 'asc'],
            'status'        => Constant::STATUS_ACTIVE,
        ]);

        return $data;
    }

    private function getBoardOfDirectors()
    {
        $data = new BoardDirector();
        $data = $data->filter(0, [
            'ordering'      => ['on_top' => 'asc', 'sorting' => 'asc'],
            'relationship'  => ['media', 'positions'],
            'status'        => Constant::STATUS_ACTIVE,
        ]);

        return $data;
    }

    private function getMilestones()
    {
        $data = new Milestone();
        $data = $data->filter(0, [
            'ordering'  => ['created_at' => 'asc'],
            'status'    => Constant::STATUS_ACTIVE,
        ]);

        return $data;
    }

    private function getCoreValue($menu_id)
    {
        $active = Constant::STATUS_ACTIVE;
        $ordering = ['created_at' => 'asc'];

        $categories = new Category();
        $categories = $categories->filter(0, [
            'status'    => $active,
            'menu'      => $menu_id,
            'ordering'  => $ordering,
        ]);

        $category_id = \Input::get('category', $categories[0]->id);

        $carousels = new Carousel();
        $carousels = $carousels->filter(0, [
            'status'    => $active,
            'ordering'  => $ordering,
            'category'  => $category_id,
        ]);

        $core_value = new CoreValue();
        $core_value = $core_value->filter(1, [
            'status'        => $active,
            'ordering'      => $ordering,
            'category'      => $category_id,
            'relationship'  => ['file', 'avatar'],
        ]);

        return ['categories' => $categories, 'carousels' => $carousels, 'core_value' => $core_value];
    }
}
