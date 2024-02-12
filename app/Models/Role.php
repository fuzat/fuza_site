<?php

namespace App\Models;

use App\User;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    const _ATTR = 'roles';

    public static function getCreateValidation()
    {
        $prefix = self::_ATTR.'-';
        return $_validate = [
            $prefix.'name' => 'required|string|alpha_dash|max:191|unique:roles,name',
            $prefix.'display_name' => 'required|string|max:191|noscript',
            $prefix.'description' => 'nullable|string|max:191|noscript',
        ];
    }

    public static function getUpdateValidation($id)
    {
        $prefix = self::_ATTR.'-';
        $_validate = self::getCreateValidation();
        $_validate[$prefix.'name'] = 'required|string|alpha_dash|max:191|unique:roles,name,'.$id.',id';
        return $_validate;
    }

    public static function getUpdatePermValidation()
    {
        $_validate['chosed_permissions'] = 'required|array';
        $_validate['chosed_permissions.*'] = 'required|exists:permissions,id';
        return $_validate;
    }

    public static function validation($params, $id = null)
    {
        $validate = ( $id ? self::getUpdateValidation($id) : self::getCreateValidation());
        if (isset($params['getUpdatePermValidation']))
            $validate = self::getUpdatePermValidation();
        $validator = \Validator::make($params, $validate);
        return $validator->fails() ? $validator->messages() : null;
    }

    public static function filter($perPage = 0, $params = [])
    {
        $data = self::query()
            ->where('id', '<>', User::SUPERADMIN_ROLE_ID)
            ->whereNotIn('name', [User::SUPERADMIN_ROLE_NAME, User::USER_ROLE_NAME]);

        if (!empty($params)) {
            if (isset($params['id']) && !empty($params['id']))
                $data = $data->where('id', $params['id']);

            if (isset($params['key_name']) && !empty($params['key_name']))
                $data = $data->where('name', $params['key_name']);

            if (isset($params['name']) && !empty($params['name']))
                $data = $data->where('display_name', 'like', '%'. $params['name'] .'%');

            if (isset($params['is_admin']) && is_bool($params['is_admin']))
                $data = $data->where('is_admin', $params['is_admin']);

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

    public static function doCreatingOrUpdating(array $params, $id = null)
    {
        $prefix = self::_ATTR.'-';
        if (!$id) { // create
            $date = date('Y-m-d H:i:s');
            $id = self::insertGetId([
                'name' => $params[$prefix.'name'],
                'display_name' => $params[$prefix.'display_name'],
                'description' => $params[$prefix.'description'],
                'editing' => 1,
                'deleting' => 1,
                'is_admin' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        } else { // update
            self::where('id', $id)->update([
                'name' => $params[$prefix.'name'],
                'display_name' => $params[$prefix.'display_name'],
                'description' => $params[$prefix.'description'],
            ]);
        }

        return true;
    }

    public static function getList($action = null)
    {
        $params['is_admin'] = true;
        $temp = Role::filter(0, $params);
        $role_arr = [];
        if (!empty($temp)) {
            if (isset($action['pluck']))
                $role_arr = $action['pluck'] == 'id' ? $temp->pluck($action['pluck'])->toArray() : $temp->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($temp as $item) {
                    $role_arr[] = ['id' => $item->id, 'name' => $item->display_name];
                }
            else
                $role_arr = $temp->pluck('display_name', 'id')->toArray();
        }
        return $role_arr;
    }
}
