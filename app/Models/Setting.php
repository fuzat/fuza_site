<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    const _ATTR = 'settings';

    public $timestamps = false;

    protected $fillable = ['id', 'setting_name', 'setting_value', 'is_editing', 'is_deleting'];

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_SETTING)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    public static function getValueObj($name, $value = false)
    {

        $item = self::where('setting_name', $name)->where('is_deleting', 0)->first();
        return $value ? $item->setting_value : $item;
    }

    public function doUpdating($request)
    {
        if (empty($params = $request->except(['_token', '_method'])))
            return false;

        foreach ($params as $key => $value) {
            if (in_array($key, ['logo-header', 'logo-footer'])) {
                $uploaded = $request->hasFile($key) ? Media::uploadFileOnly($request->file($key), ($key == 'logo-header') ? Media::OBJ_TYPE_LOGO_HEADER : Media::OBJ_TYPE_LOGO_FOOTER) : null;

                if (isset($uploaded['url']) && !empty($uploaded) && !empty($value))
                    Media::deletePublicFile($value);

                $this->newQuery()->where('setting_name', $key)->update([
                    'setting_value' => (isset($uploaded['url']) && !empty($uploaded)) ? $uploaded['url'] : $value,
                ]);
            } else if (in_array($key, ['seo-title', 'seo-description', 'logo-footer-text', 'address', 'email'])) {
                $data = $this->newQuery()->where('setting_name', $key)->first();

                Datameta::updateDataMeta([
                    'id' => $data->id,
                    'type' => Datameta::TYPE_SETTING,
                    'field' => $key . '_' . $params['locale'],
                    'value' => $value,
                ]);

                $data->setting_value = implode('; ', Datameta::query()
                    ->where('data_id', $data->id)
                    ->whereNotNull('data_value')
                    ->where('data_field', 'like', $key . '_%')
                    ->where('data_type', Datameta::TYPE_SETTING)
                    ->get(['data_value'])->pluck('data_value')->toArray());

                $data->save();
            } else {
                $this->newQuery()->where('setting_name', $key)->update(['setting_value' => $value]);
            }
        }

        return true;
    }

    public function filter($perPage = 0, $params = [])
    {
        $data = self::query();

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('setting_name', $params['name']);

        if ($perPage != 1)
            $data = $data->get();
        else
            $data = $data->first();

        return $data;
    }
}
