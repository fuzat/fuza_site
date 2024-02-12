<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HashKey extends Model
{
    protected $table = 'hash_keys';

    protected $fillable = ['id', 'obj_id', 'obj_type', 'code'];

    const _OBJ_TYPE_JOB = 'jobs';
    const _OBJ_TYPE_NEWS = 'news';
    const _OBJ_TYPE_POST = 'posts';
    const _OBJ_TYPE_BUSINESS = 'businesses';

    public static function getData($obj_type, $code)
    {
        return self::where('code', $code)->where('obj_type', $obj_type)->first();
    }

    public static function doUpdatingOrCreating($params = [])
    {
        self::query()->updateOrCreate([
            'obj_id'    => $params['id'],
            'obj_type'  => $params['type'],
        ], [
            'obj_id'    => $params['id'],
            'obj_type'  => $params['type'],
            'code'      => $params['code'],
        ]);
    }

    public static function removeRecord($obj_id, $obj_type, $code = null)
    {
        $data = self::query();

        $data = is_array($obj_type) ? $data->whereIn('obj_type', $obj_type) : $data->where('obj_type', $obj_type);

        if (!empty($obj_id))
            $data = is_array($obj_id) ? $data->whereIn('obj_id', $obj_id) : $data->where('obj_id', $obj_id);

        if (!empty($code))
            $data = $data->where('code', $code);

        $data->delete();
    }
}
