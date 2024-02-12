<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    const _ATTR = 'tags';

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    public static function getCreateValidation()
    {
        $prefix = self::_ATTR.'-';
        return $_validate = [
            $prefix.'name' => 'required|string|max:100|noanytag',
        ];
    }

    public static function getUpdateValidation($id)
    {
        $prefix = self::_ATTR.'-';
        $_validate = self::getCreateValidation();
        return $_validate;
    }

    public static function validation($params, $id = null)
    {
        $validate = [];
        if (isset($params['getCreateValidation'])) $validate = self::getCreateValidation();
        elseif (isset($params['getUpdateValidation'])) $validate = self::getUpdateValidation($id);
        $validator = \Validator::make($params, $validate);
        return $validator->fails() ? $validator->messages() : null;
    }

    public static function doCreatingOrUpdating(array $params, $id = null)
    {
        $prefix = self::_ATTR.'-';

        $data = self::firstOrCreate(['name' => $params[$prefix.'name'],]);
        $data->save();

        return $data;
    }

}
