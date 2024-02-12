<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    const _ATTR = 'news';

    private $_rules = [];

    protected $fillable = ['id', 'category_id', 'name', 'slug', 'view', 'status', 'hot_news', 'public_date'];

    protected $dates = ['deleted_at'];

    public function hash_key()
    {
        return $this->hasOne(HashKey::class, 'obj_id')->where('obj_type', HashKey::_OBJ_TYPE_NEWS);
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_NEWS_MEDIA);
    }

    public function media_detail()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_NEWS_MEDIA_DETAIL);
    }

    public function media_big()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_NEWS_MEDIA_BIG);
    }

    public function carousel()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_NEWS_CAROUSEL);
    }

    public function video()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_NEWS_VIDEO);
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_NEWS);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_NEWS)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params)
    {
        $this->_rules = [
            self::_ATTR.'-name'         => 'required|string|max:250|noanytag',
            self::_ATTR.'-category'     => 'required|exists:categories,id',
            self::_ATTR.'-public_date'  => 'required',
            self::_ATTR.'-file-large'   => 'required|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image),
            self::_ATTR.'-video'        => 'nullable|file|max:' . (Media::_MAX_FILE_SIZE_CV * 1024) . '|mimes:' . implode(',', Media::$_type_video),
            self::_ATTR.'-content'      => 'required|string|noscript',
            self::_ATTR.'-seo_title'        => 'nullable|string|max:10000|noanytag',
            self::_ATTR.'-seo_description'  => 'nullable|string|max:10000|noanytag',
            'hot_news'                  => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'status'                    => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                    => 'required|in:' . implode(',', Datameta::$_lang),
        ];

        if ($params['hot_news'] == Constant::STATUS_ACTIVE) {
            $this->_rules[self::_ATTR.'-file-big'] = 'required|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image);
            $this->_rules[self::_ATTR.'-carousel'] = 'required|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image);
        } else {
            $this->_rules[self::_ATTR.'-file-big'] = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image);
            $this->_rules[self::_ATTR.'-carousel'] = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image);
        }

        return $this->_rules;
    }

    private function getUpdateValidation($params, $id)
    {
        $this->getCreateValidation($params);

        $this->_rules[self::_ATTR.'-file-big']      = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image);
        $this->_rules[self::_ATTR.'-carousel']      = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image);
        $this->_rules[self::_ATTR.'-file-large']    = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:' . implode(',', Media::$_type_image);

        return $this->_rules;
    }

    public function validation(array $params, $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation($params, $id) : $this->getCreateValidation($params));

        if ($validator->fails())
            return $validator;

        return null;
    }

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['not_id']) && !empty($params['not_id']))
            $data = is_array($params['not_id']) ? $data->whereNotIn('id', $params['not_id']) : $data->where('id', '!=', $params['not_id']);

        if (isset($params['category']) && !empty($params['category']))
            $data = $data->where('category_id', $params['category']);

        if (isset($params['hot_news']) && !empty($params['hot_news']))
            $data = $data->where('hot_news', $params['hot_news']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%'. $params['name'] .'%');

        if (isset($params['slug']) && !empty($params['slug']))
            $data = $data->where('slug', 'like', '%'. $params['slug'] .'%');

        if (isset($params['show_date']) && !empty($params['show_date']) && $params['show_date'] == true)
            $data = $data->whereDate('public_date', '<=', date('Y-m-d'));

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $v)
                $data = $data->orderBy($k, $v);
        else
            $data = $data->latest();

        if (isset($params['count']) && !empty($params['count']) && $params['count'] == true) {
            $data = $data->count();
        } else {
            if (!empty($perPage))
                $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
            else
                $data = $data->get($columns);
        }

        return $data;
    }

    public function doCreatingOrUpdating(array $params, $id = null)
    {
        $attr = self::_ATTR . '-';

        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_NEWS,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_NEWS,
                    'field' => 'slug_' . $v,
                    'value' => ($v == $params['locale']) ? str_slug($params[$attr . 'name']) : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_NEWS,
                    'field' => 'content_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'content'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_NEWS,
                    'field' => 'seo_title_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'seo_title'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_NEWS,
                    'field' => 'seo_description_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'seo_description'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_NEWS,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_NEWS,
                'field' => 'slug_' . $params['locale'],
                'value' => str_slug($params[$attr . 'name']),
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_NEWS,
                'field' => 'content_' . $params['locale'],
                'value' => $params[$attr . 'content'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_NEWS,
                'field' => 'seo_title_' . $params['locale'],
                'value' => (isset($params[$attr . 'seo_title'])) ? $params[$attr . 'seo_title'] : null,
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_NEWS,
                'field' => 'seo_description_' . $params['locale'],
                'value' => (isset($params[$attr . 'seo_description'])) ? $params[$attr . 'seo_description'] : null,
            ]);
        }

        $data = $this->newQuery()->find($id);

        $data->name = implode('; ', Datameta::query()
            ->where('data_id', $id)
            ->whereNotNull('data_value')
            ->where('data_field', 'like', 'name_%')
            ->where('data_type', Datameta::TYPE_NEWS)
            ->get(['data_value'])->pluck('data_value')->toArray());

        $data->slug = implode('; ', Datameta::query()
            ->where('data_id', $id)
            ->whereNotNull('data_value')
            ->where('data_field', 'like', 'slug_%')
            ->where('data_type', Datameta::TYPE_NEWS)
            ->get(['data_value'])->pluck('data_value')->toArray());

        $data->public_date = \Carbon\Carbon::createFromFormat('d/m/Y', $params[$attr . 'public_date'])->format('Y-m-d');
        $data->category_id = $params[$attr . 'category'];
        $data->hot_news = $params['hot_news'];
        $data->status = $params['status'];
        $data->save();

        SearchResult::updateSearchResult(['type' => SearchResult::_OBJ_TYPE_NEWS, 'id' => $id]);

        if (empty($data->hash_key)) {
            HashKey::doUpdatingOrCreating([
                'type'  => HashKey::_OBJ_TYPE_NEWS,
                'code'  => rand(),
                'id'    => $id,
            ]);
        }

        return $id;
    }

    public static function sumJob($params = [])
    {
        $params['count'] = true;
        $params['status'] = Constant::STATUS_ACTIVE;

        $sum = new News();
        $sum = $sum->filter(0, $params);

        return $sum;
    }
}
