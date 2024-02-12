<?php

namespace App;

use App\Models\Application;
use App\Models\Business;
use App\Models\Datameta;
use App\Models\Industry;
use App\Models\MailBox;
use App\Models\UserApp;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'status', 'phone_number', 'verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $dates = ['deleted_at'];

    public function apps()
    {
        return $this->hasMany(UserApp::class, 'user_id', 'id');
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function fields()
    {
        return $this->belongsToMany(Industry::class, 'user_field')->withPivot(['is_global',]);
    }

    public function careers()
    {
        return $this->belongsToMany(Business::class, 'user_career');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_department');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function applicant()
    {
        return $this->hasOne(Application::class, 'user_id');
    }

    const SUPERADMIN_ID = 1;
    const SUPERADMIN_ROLE_ID = 1;
    const SUPERADMIN_ROLE_NAME = 'superadmin';
    const USER_ROLE_NAME = 'user';
    const USER_ROLE_ID = 2;


    const _ATTR_ADMIN = 'admin';
    const _ATTR_USER = 'applicants';

    # Overwite the "can" function of vendor\zizaco\entrust\src\Entrust\Traits\EntrustUserTrait
    public function can($permission, $requireAll = false)
    {
//        if ($this->hasRole(self::SUPERADMIN_ROLE_NAME))
//            return true;

        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->can($permName);

                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                // Validate against the Permission table
                foreach ($role->cachedPermissions() as $perm) {
                    if (str_is( $permission, $perm->name) ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function getCreateAdminValidation()
    {
        $prefix = self::_ATTR_ADMIN.'-';
        return $_validate = [
            $prefix.'name' => 'required|string|max:191|noscript',
            $prefix.'email' => 'required|string|email|max:191|noscript|unique:users,email',
            $prefix.'phone_number' => 'nullable|digits_between:6,15',
            $prefix.'position' => 'required|numeric|exists:positions,id',
            $prefix.'role' => 'required|numeric|exists:roles,id|not_in:'.self::SUPERADMIN_ROLE_ID,
            'status' => 'required|in:1,2',
            $prefix.'department' => 'required|array',
            $prefix.'department.*' => 'required|array',
            $prefix.'department.*.all' => 'required|in:0,1',
            $prefix.'department.*.field' => 'nullable|array',
            $prefix.'department.*.field.*' => 'nullable|numeric|exists:departments,id',
        ];
    }

    public static function getCreateUserValidation()
    {
        $prefix = self::_ATTR_USER.'-';
        return $_validate = [
            $prefix.'name' => 'required|string|max:191|noscript',
            $prefix.'email' => 'required|string|email|max:191|noscript|unique:users,email',
            'status' => 'required|in:1,2',
        ];
    }

    public static function getUpdateAdminValidation($id)
    {
        $prefix = self::_ATTR_ADMIN.'-';
        $_validate = self::getCreateAdminValidation();
        $_validate[$prefix.'email'] = 'nullable|string|email|max:191|noscript|unique:users,email,'.$id.',id';
        return $_validate;
    }

    public static function getUpdateUserValidation($id)
    {
        $prefix = self::_ATTR_USER.'-';
        $_validate = self::getCreateUserValidation();
        $_validate[$prefix.'email'] = 'nullable|string|email|max:191|noscript|unique:users,email,'.$id.',id';
        return $_validate;
    }

    public static function getUpdateProfileValidation()
    {
        $prefix = self::_ATTR_ADMIN.'-';
        $_validate = [
            $prefix.'name' => 'required|string|max:191|noscript',
            $prefix.'phone_number' => 'nullable|digits_between:6,15',
            $prefix.'current_password' => 'nullable|string|min:6|max:64',
            $prefix.'new_password' => 'nullable|required_with:'.$prefix.'current_password'.'|string|min:6|max:64|confirmed|different:'.$prefix.'current_password',
        ];
        return $_validate;
    }

    public static function validation($params, $id = null)
    {
        $validate = [];
        if (isset($params['getCreateAdminValidation'])) $validate = self::getCreateAdminValidation();
        elseif (isset($params['getUpdateAdminValidation'])) $validate = self::getUpdateAdminValidation($id);
        elseif (isset($params['getCreateUserValidation'])) $validate = self::getCreateUserValidation();
        elseif (isset($params['getUpdateUserValidation'])) $validate = self::getUpdateUserValidation($id);
        elseif (isset($params['getUpdateProfileValidation'])) $validate = self::getUpdateProfileValidation();
        $validator = \Validator::make($params, $validate);
        return $validator->fails() ? $validator->messages() : null;
    }

    public function filter($perPage = 0, $params = [])
    {
        $data = self::query()->where('id', '<>', self::SUPERADMIN_ID);

//        if (!\Entrust::hasRole(self::SUPERADMIN_ROLE_NAME)) {}

        if (!empty($params)) {
            if (isset($params['id']) && !empty($params['id']))
                $data = $data->where('id', $params['id']);

            if (isset($params['name']) && !empty($params['name']))
                $data = $data->where('name', 'like', '%'. $params['name'] .'%');

            if (isset($params['email']) && !empty($params['email']))
                $data = $data->where('email', $params['email']);

            if (isset($params['status']) && !empty($params['status']))
                $data = $data->where('status', $params['status']);

            if (isset($params['role']) && !empty($params['role']))
                $data = $data->whereExists(function ($query) use ($params) {
                    $query->select(\DB::raw(1))
                        ->from('role_user')
                        ->whereRaw('role_user.user_id = users.id')
                        ->where('role_id', $params['role']);
                });

            if (isset($params['is_admin']) && is_bool($params['is_admin']))
                $data = $data->where('is_admin', $params['is_admin']);

            if (isset($params['is_deleted']) && is_bool($params['is_deleted']))
                $data = $data->where('is_deleted', $params['is_deleted']);

            if (isset($params['ordering']) && !empty($params['ordering']))
                foreach ($params['ordering'] as $k => $i)
                    $data = $data->orderBy($k, $i);
        }

        $data = $data->orderBy('created_at', 'desc');

        if ($perPage > 1)
            $data = $data->paginate($perPage);
        elseif ($perPage === 1 || $perPage === '1')
            $data = $data->first();
        else
            $data = $data->get();

        return $data;
    }

    public static function doCreatingOrUpdatingAdmin(array $params, $id = null)
    {
        $prefix = self::_ATTR_ADMIN.'-';

        $field_arr = Industry::getList(['pluck' => 'id']);
        $dept_arr = Department::getList(['pluck' => 'id']);

        $my_fields = $my_depts = [];
        $input_field_dept = $params[$prefix.'department'];
        if (!empty($input_field_dept)) {
            foreach ($input_field_dept as $fid => $item) {
                if ($item['all'] == 1) {
                    $my_fields[$fid] = ['is_global' => 1];
                    if (isset($item['field']) && !empty($item['field'])) {
                        $my_depts = array_merge($my_depts, array_intersect($dept_arr, $item['field']));
                    }
                } else {
                    if (isset($item['field']) && !empty($item['field'])) {
                        $my_fields[$fid] = ['is_global' => 0];
                        $my_depts = array_merge($my_depts, array_intersect($dept_arr, $item['field']));
                    }
                }
            }
        }

        if (!$id) { // create
            $key = \Str::random(8);
            $data = self::create([
                'name' => $params[$prefix.'name'],
                'email' => $params[$prefix.'email'],
                'password' => \Hash::make($key),
                'phone_number' => $params[$prefix.'phone_number'],
                'department_id' => 0,
                'position_id' => $params[$prefix.'position'],
                'is_deleted' => 0,
                'is_admin' => 1,
                'status' => $params['status'],
                'lang' => Datameta::LANG_VN
            ]);
            $data->save();

            MailBox::doCreate([
                'object_id' => $data->id,
                'name'      => $data->name,
                'email'     => $data->email,
                'subject'   => MailBox::_MAIL_SUBJECT[MailBox::_TYPE_REGISTER],
                'type'      => MailBox::_TYPE_REGISTER,
                'priority'  => MailBox::_PRIORITY_URGENT,
                'content' => [
                    'name'      => $data->name,
                    'email'     => $data->email,
                    'phone'     => $data->phone_number,
                    'password'  => encrypt($key),
                    'hash'  => null,
                    'is_admin' => 1,
                ],
            ], 'user');

        } else { // update
            $data = User::find($id);
            $data->update([
                'name' => $params[$prefix.'name'],
                'phone_number' => $params[$prefix.'phone_number'],
                'department_id' => 0,
                'position_id' => $params[$prefix.'position'],
                'status' => $params['status'],
            ]);
        }
        $data->roles()->sync($params[$prefix.'role']);

        $data->fields()->sync($my_fields);
        $data->departments()->sync($my_depts);

        return true;
    }

    public function doUpdatingProfileAdmin(array $params)
    {
        $prefix = self::_ATTR_ADMIN.'-';
        $this->name = $params[$prefix.'name'];
        $this->phone_number = $params[$prefix.'phone_number'];
        if (!empty($params[$prefix.'new_password'])) {
            $this->password = \Hash::make($params[$prefix.'new_password']);
        }
        $this->save();

        return true;
    }

    public static function doCreatingUser(array $params)
    {
        $prefix = self::_ATTR_USER.'-';

        $key = isset($params[$prefix.'password']) ? $params[$prefix.'password'] : \Str::random(8);

        $data = self::create([
            'name' => $params[$prefix.'name'],
            'email' => $params[$prefix.'email'],
            'password' => \Hash::make($key),
            'phone_number' => isset($params[$prefix.'phone_number']) ? $params[$prefix.'phone_number'] : null,
            'is_deleted' => 0,
            'is_admin' => 0,
            'status' => $params['status'],
            'lang' => \LaravelLocalization::getCurrentLocale(),
            'verified' => isset($params[$prefix.'verified']) ? $params[$prefix.'verified'] : null,
        ]);
        $data->save();

        $data->roles()->sync(self::USER_ROLE_ID);

        if (empty($data->is_admin)) {
            $applicant = Application::where('email', $data->email)->first();
            if (empty($applicant)) {
                Application::create([
                    'user_id'   => $data->id,
                    'email'     => $data->email,
                    'name'      => $data->name,
                    'cellphone' => $data->phone_number,
                ]);
            } else {
                Application::where('email', $data->email)->update([
                    'user_id'     => $data->id,
                    'name'      => $data->name,
                    'cellphone' => $data->phone_number,
                ]);
            }
        }

        MailBox::doCreate([
            'object_id' => $data->id,
            'name'      => $data->name,
            'email'     => $data->email,
            'subject'   => MailBox::_MAIL_SUBJECT[MailBox::_TYPE_REGISTER],
            'type'      => MailBox::_TYPE_REGISTER,
            'priority'  => MailBox::_PRIORITY_URGENT,
            'content' => [
                'name'      => $data->name,
                'email'     => $data->email,
                'phone'     => $data->phone_number,
                'password'  => empty($data->verified) ? encrypt($key) : '',
                'hash'  => $data->verified,
                'is_admin' => 0,
            ],
        ], 'user');

        return $data;
    }

}
