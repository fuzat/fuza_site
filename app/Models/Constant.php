<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    const PER_PAGE_DEFAULT = 20;
    const PER_PAGE_10   = 10;
    const PER_PAGE_15   = 15;
    const PER_PAGE_8    = 8;
    const PER_PAGE_6    = 6;

    const _NEW_JOB = 7;

    const NA = 'N/A';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const ARRAY_STATUS = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    const _IS_ADMIN = 1;
    const _NOT_ADMIN = 0;

    const _DELETED = 1;
    const _DELETED_NOT = 2;

    const _EDITED = 1;
    const _EDITED_NOT = 0;

    const _LIMIT = 8;

    const _MAX_EXPORT = 10000;
    const _EXPORT_PATH  = "uploads/export-temp";
    const _EXPORT_MEMORY_LIMIT  = "2048M";
    const _EXPORT_EXCUTE_TIME  = "3600";

    public static function shareView($options = [])
    {
        $active = Constant::STATUS_ACTIVE;
        $lang = \LaravelLocalization::getCurrentLocale();

        $share = view()->share('options', [
            'settings' => Setting::query()
                ->where('is_deleting', false)
                ->get(['setting_value', 'setting_name'])
                ->pluck('setting_value', 'setting_name')
                ->toArray(),

            'header_menu' => Menu::query()
                ->where('status', $active)
                ->whereNull('parent_id')
                ->with(['children', 'posts'])
                ->orderBy('sorting')
                ->get(),

            'headquarter' => GlobalPresence::query()
                ->where('headquarter', $active)
                ->latest()
                ->first(),

            'seo' => [
                'title'         => optional(Datameta::getData(['type' => 'settings', 'field' => 'seo-title'], $lang))->data_value,
                'description'   => optional(Datameta::getData(['type' => 'settings', 'field' => 'seo-description'], $lang))->data_value,
                'image'         => null,
            ],

            'languages' => Language::query()
                ->where('status', $active)
                ->get(['code', 'name', 'regional'])->toArray(),
        ]);

        if (!isset($options['auth'])) {
            $auth = auth()->user();
            view()->share('auth', $auth);
        }

        return $share;
    }

    public static function getListLevel($action = null)
    {
        $arr = [];
        if (isset($action['api']))
            foreach (__("datametas.select-box.position-level") as $key => $value)
                $arr[] = ['id' => $key, 'name' => $value];
        else
            $arr = __("datametas.select-box.position-level");

        return $arr;
    }

}
