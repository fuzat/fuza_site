<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;

    const _ATTR = 'jobs';

    protected $fillable = [
        'id', 'user_id', 'company_id', 'name', 'type_id', 'level_id', 'salary', 'experiences', 'qualification', 'deadline_apply', 'status',
    ];

    protected $dates = ['deleted_at'];

    private $_rules = [];

    public function hash_key()
    {
        return $this->hasOne(HashKey::class, 'obj_id')->where('obj_type', HashKey::_OBJ_TYPE_JOB);
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_JOB);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_JOB);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'type_id');
    }

    public function job_level()
    {
        return $this->belongsTo(JobLevel::class, 'level_id');
    }

    public function locations()
    {
        return $this->belongsToMany(CompanyLocation::class, 'job_location','job_id','location_id');
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'job_industry');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_JOB)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation()
    {
        $attr = self::_ATTR . '-';

        $this->_rules = [
            $attr . 'name'      => 'required|string|max:70|noanytag',
            $attr . 'type'      => 'required|exists:job_types,id',
            $attr . 'level'     => 'required|exists:job_levels,id',
            $attr . 'salary'    => 'required|string|max:70|noanytag',
            $attr . 'file'      => 'nullable|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image),
            $attr . 'company'           => 'required|exists:companies,id',
            $attr . 'location'          => 'required|array',
            $attr . 'location.*'        => 'required|exists:company_locations,id',
            $attr . 'industry'          => 'required|array',
            $attr . 'industry.*'        => 'required|exists:industries,id',
            $attr . 'deadline_apply'    => 'required',
            $attr . 'experiences'       => 'required|string|max:70|noanytag',
            $attr . 'qualification'     => 'required|string|max:70|noanytag',
            $attr . 'benefit'           => 'nullable|string|max:2500|noscript',
            $attr . 'description'       => 'required|string|max:2500|noscript',
            $attr . 'requirement'       => 'required|string|max:2500|noscript',
            'status' => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale' => 'required|in:' . implode(',', Datameta::$_lang),
        ];

        return $this->_rules;
    }

    private function getUpdateValidation()
    {
        $this->getCreateValidation();
        $this->_rules[self::_ATTR.'-file'] = 'nullable|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image);
        return $this->_rules;
    }

    public function validation($params = [], $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation() : $this->getCreateValidation());

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

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%' . $params['name'] . '%');

        if (isset($params['type']) && !empty($params['type']))
            $data = $data->where('type_id', $params['type']);

        if (isset($params['level']) && !empty($params['level']))
            $data = $data->where('level_id', $params['level']);

        if (isset($params['salary']) && !empty($params['salary']))
            $data = $data->where('salary', 'like', '%' . $params['salary'] . '%');

        if (isset($params['experiences']) && !empty($params['experiences']))
            $data = $data->where('experiences', 'like', '%' . $params['experiences'] . '%');

        if (isset($params['qualification']) && !empty($params['qualification']))
            $data = $data->where('qualification', 'like', '%' . $params['qualification'] . '%');

        if (isset($params['deadline_apply']) && !empty($params['deadline_apply']))
            $data = $data->whereDate('deadline_apply', $params['deadline_apply']);

        if (isset($params['expired']) && !empty($params['expired']))
            $data = $data->whereDate('deadline_apply', '>=', $params['expired']);

        if (isset($params['company']) && !empty($params['company']))
            $data = $data->where('company_id', $params['company']);

        if (isset($params['location']) && !empty($params['location']))
            $data = $data->whereHas('locations', function ($query) use ($params) {
                $query->where('company_locations.location_id', $params['location']);
            });

        if (isset($params['position']) && !empty($params['position']))
            $data = $data->whereHas('metas', function ($query) use ($params) {
                $query->where('data_value', 'like', '%' . $params['position'] . '%')->where('data_field', 'like', 'name_' . \LaravelLocalization::getCurrentLocale());
            });

        if (isset($params['industry']) && !empty($params['industry']))
            $data = $data->whereHas('industries', function ($query) use ($params) {
                $query->where('id', $params['industry']);
            });

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $v)
                $data = $data->orderBy($k, $v);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && $perPage == 0)
            $data = $data->take($params['limit']);

        if (isset($params['count']) && !empty($params['count']) && $params['count'] == true) {
            $data = $data->count();
        } else {
            if ($perPage > 0)
                $data = ($perPage == 1) ? $data->first($columns) :  $data->paginate($perPage, $columns);
            else
                $data = $data->get($columns);
        }

        return $data;
    }

    public function doCreatingOrUpdating($params = [], $id = null)
    {
        $attr = self::_ATTR . '-';
        $arr = ['name', 'type', 'level', 'salary', 'experiences', 'qualification', 'benefit', 'description', 'requirement'];

        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                foreach ($arr as $item) {
                    Datameta::updateDataMeta([
                        'id' => $id,
                        'type' => Datameta::TYPE_JOB,
                        'field' => $item . '_' . $v,
                        'value' => ($v == $params['locale']) ? $params[$attr . $item] : null,
                    ]);
                }
            }
        } else {
            foreach ($arr as $item) {
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_JOB,
                    'field' => $item . '_' . $params['locale'],
                    'value' => $params[$attr . $item],
                ]);
            }
        }

        $this->newQuery()->where('id', $id)->update([
            'name' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'name_%')
                ->where('data_type', Datameta::TYPE_JOB)
                ->get(['data_value'])->pluck('data_value')->toArray()),

            'salary' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'salary_%')
                ->where('data_type', Datameta::TYPE_JOB)
                ->get(['data_value'])->pluck('data_value')->toArray()),

            'experiences' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'experiences_%')
                ->where('data_type', Datameta::TYPE_JOB)
                ->get(['data_value'])->pluck('data_value')->toArray()),

            'qualification' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'qualification_%')
                ->where('data_type', Datameta::TYPE_JOB)
                ->get(['data_value'])->pluck('data_value')->toArray()),

            'deadline_apply'    => Carbon::createFromFormat('d/m/Y', $params[$attr . 'deadline_apply'])->format('Y-m-d'),
            'company_id'        => $params[$attr . 'company'],
            'level_id'          => $params[$attr . 'level'],
            'type_id'           => $params[$attr . 'type'],
            'status'            => $params['status'],
        ]);

        $data = $this->filter(1, ['relationship' => ['locations', 'industries'], 'id' => $id]);

        $data->locations()->detach();
        $data->locations()->attach($params[$attr . 'location']);

        $data->industries()->detach();
        $data->industries()->attach($params[$attr . 'industry']);

        SearchResult::updateSearchResult(['type' => SearchResult::_OBJ_TYPE_JOB, 'id' => $id]);

        if (empty($data->hash_key)) {
            HashKey::doUpdatingOrCreating([
                'type'  => HashKey::_OBJ_TYPE_JOB,
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

        $sum = new self();
        $sum = $sum->filter(0, $params);

        return $sum;
    }

    public static function getList($action = null)
    {
        $params = [];
        $params['company'] = isset($action['company']) ? $action['company'] : null;
        $params['expired'] = isset($action['expired']) ? $action['expired'] : null;
        $params['status'] = Constant::STATUS_ACTIVE;

        $temp = new self();
        $temp = $temp->filter(0, $params);

        $items_arr = [];

        if (!empty($temp)) {
            if (isset($action['pluck']))
                $items_arr = ($action['pluck'] == 'id') ? $temp->pluck($action['pluck'])->toArray() : $temp->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($temp as $item)
                    $items_arr[] = ['id' => $item->id, 'name' => optional($item->datameta('', 'name'))->data_value];
            else
                foreach ($temp as $item)
                    $items_arr[$item->id] = optional($item->datameta('', 'name'))->data_value;
        }

        return $items_arr;
    }
}
