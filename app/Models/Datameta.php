<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;


class Datameta extends Model
{
    use Notifiable, Sortable;

    const TYPE_INDUSTRY     = 'industries';
    const TYPE_BUSINESS     = 'businesses';
    const TYPE_DEPARTMENT   = 'departments';
    const TYPE_LOCATION     = 'locations';
    const TYPE_BANNER       = 'banners';
    const TYPE_CATEGORY     = 'categories';
    const TYPE_JOB          = 'jobs';
    const TYPE_BENEFIT      = 'benefits';
    const TYPE_MENU         = 'menus';
    const TYPE_POST         = 'posts';
    const TYPE_SETTING      = 'settings';
    const TYPE_POSITION     = 'positions';
    const TYPE_GLOBAL_PRESENCE  = 'global_presence';
    const TYPE_BOARD_DIRECTOR   = 'board_directors';
    const TYPE_CAROUSEL     = 'carousels';
    const TYPE_NEWS         = 'news';
    const TYPE_CORE_VALUE   = 'core_values';
    const TYPE_MILESTONE    = 'milestones';
    const TYPE_COMPANY      = 'companies';
    const TYPE_COMPANY_LOCATION = 'company_locations';
    const TYPE_VISION_MISSION   = 'vision_mission';
    const TYPE_JOB_LEVEL    = 'job_levels';
    const TYPE_JOB_TYPE     = 'job_types';

    const LANG_EN = 'en';
    const LANG_VN = 'vi';
    const LANG_ZH = 'zh';
    const LANG_RU = 'ru';
    const LANG_ES = 'es';
    const LANG_JA = 'ja';

    protected $fillable = [ 'data_type', 'data_id', 'data_field', 'data_value'];

    static private $_data_field = 'name_';

    public $timestamps = false;

    static public $_lang = [
        self::LANG_EN,
        self::LANG_VN,
        self::LANG_ZH,
        self::LANG_RU,
        self::LANG_ES,
        self::LANG_JA,
    ];

    public static function setDataField($field)
    {
        if (empty($field))
            return self::$_data_field;

        return self::$_data_field = $field . '_';
    }


    public static function updateDataMeta($input = []) {
        if (empty($input))
            return null;

        self::query()->updateOrCreate([
            'data_id'       => $input['id'],
            'data_type'     => $input['type'],
            'data_field'    => $input['field'],
        ], [
            'data_value' => $input['value'],
        ]);

        return true;
    }

    public static function insertArrayDataMeta($array = [])
    {
        if (empty($array))
            return null;

        self::query()->insert($array);
        return true;
    }

    public static function removeRecord($data_id = null, $data_type = '', $data_field = '')
    {
        $meta = self::query();
        $meta = is_array($data_type) ? $meta->whereIn('data_type', $data_type) : $meta->where('data_type', $data_type);

        if (!empty($data_id))
            $meta = is_array($data_id) ? $meta->whereIn('data_id', $data_id) : $meta->where('data_id', $data_id);

        if (!empty($data_field))
            $meta = $meta->where('data_field', 'like', $data_field . '%');

        return $meta->delete();
    }

    public static function getData($array = [], $locale = '')
    {
        if (empty($locale))
            $locale = \LaravelLocalization::getCurrentLocale();

        $data = self::query();

        if (isset($array['field']) && !empty($array['field']))
            $data = $data->where('data_field', $array['field'] . '_' . $locale);

        if (isset($array['type']) && !empty($array['type']))
            $data = $data->where('data_type', $array['type']);

        if (isset($array['id']) && !empty($array['id']))
            $data = $data->where('data_id', $array['id']);

        return $data->first();
    }

    public static function getExistLanguages($array = [])
    {
        return self::query()
            ->where('data_field', 'like', $array['field'] . '_%')
            ->where('data_type', $array['type'])
            ->where('data_id', $array['id'])
            ->whereNotNull('data_value')
            ->get();
    }
}
