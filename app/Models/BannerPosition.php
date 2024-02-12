<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPosition extends Model
{
    public $timestamps = false;

    const _PAGE_HOME            = 1;
    const _PAGE_POST            = 2;
    const _PAGE_CAREER          = 3;

    const  _SIZE_WEB = [
        1 => '(1920*740)',
        2 => '(1920*440)',
        3 => '(381*800)',
    ];

    const _SIZE_MOBILE = [
        1 => '(720*400)',
        2 => '(720*400)',
        3 => '(381*800)',
    ];

    public static function getAll($conditions = [])
    {
        $data = self::query()->where('status', Constant::STATUS_ACTIVE);
        if (!empty($conditions)) {
            foreach ($conditions as $v) {
                $data = $data->where($v[0], $v[1], $v[2]);
            }
        }
        $data = $data->get(['id', 'name']);

        return $data->count() ? $data->pluck('name', 'id')->toArray() : [];
    }

    public static function getSizeWeb($key = 1)
    {
        return self::_SIZE_WEB[$key];
    }

    public static function getSizeMobile($key = 1)
    {
        return self::_SIZE_MOBILE[$key];
    }
}
