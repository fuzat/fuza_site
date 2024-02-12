<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\Exception\NotSupportedException;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'medias';

    protected $fillable = [
        'id', 'obj_id', 'obj_type',
        'type', 'size', 'name', 'status', 'locale',
        'path', 'full_path', 'thumbnail_path', 'web_path', 'app_path',
    ];

    protected $dates = ['deleted_at'];

    const _TYPE_IMAGE           = 'image';
    const _TYPE_VIDEO           = 'video';
    const _TYPE_FILE            = 'file';

    const OBJ_TYPE_BANNER           = 'banners';
    const OBJ_TYPE_BANNER_MOBILE    = 'mobile_banners';

    const OBJ_TYPE_BUSINESS_AVATAR      = 'business-avatar';
    const OBJ_TYPE_BUSINESS_IMAGE       = 'business-file';
    const OBJ_TYPE_BUSINESS_ICON        = 'business-icon';
    const OBJ_TYPE_BUSINESS_ICON_ACT    = 'business-icon-act';
    const OBJ_TYPE_BUSINESS_IMAGE_HOME  = 'business-file-home';
    const OBJ_TYPE_BUSINESS_PRODUCTS_BACKGROUND  = 'business-products-background';

    const OBJ_TYPE_DIRECTOR_AVATAR      = 'director-avatar';
    const OBJ_TYPE_DIRECTOR_AVATAR_BIG  = 'director-avatar-big';

    const OBJ_TYPE_LOGO_HEADER = 'logo-header';
    const OBJ_TYPE_LOGO_FOOTER = 'logo-footer';

    const OBJ_TYPE_JOB          = 'jobs';
    const OBJ_TYPE_POST         = 'posts';
    const OBJ_TYPE_GROUP        = 'groups';
    const OBJ_TYPE_PARTNER      = 'partners';
    const OBJ_TYPE_COMPANY      = 'companies';
    const OBJ_TYPE_MILESTONES   = 'milestones';
    const OBJ_TYPE_APPLICANT_CV         = 'applicant-cv';
    const OBJ_TYPE_CORE_VALUE_FILE      = 'core-value-file';
    const OBJ_TYPE_CORE_VALUE_AVATAR    = 'core-value-avatar';
    const OBJ_TYPE_CORE_VALUE_FILE_HOW  = 'core-value-file-how';
    const OBJ_TYPE_NEWS_MEDIA           = 'news-media';
    const OBJ_TYPE_NEWS_MEDIA_DETAIL    = 'news-media-detail';
    const OBJ_TYPE_NEWS_MEDIA_BIG       = 'news-media-big';
    const OBJ_TYPE_NEWS_CAROUSEL        = 'news-carousel';
    const OBJ_TYPE_NEWS_VIDEO           = 'news-media-video';
    const OBJ_TYPE_VISION_MISSION_ACTIVE    = 'vision-mission-active';
    const OBJ_TYPE_VISION_MISSION_INACTIVE  = 'vision-mission-inactive';
    const OBJ_TYPE_POST_VISION_MISSION      = 'post-vision-mission';

    const _MAX_FILE_SIZE_AVATAR = 2; // MB
    const _MAX_FILE_SIZE_CV = 5; // MB

    static $_type_image = ['jpeg', 'png', 'jpg'];
    static $_type_video = ['flv', 'mp4', 'mov', 'avi', 'wmv', '3gp', 'ogv', 'webm'];
    static $_type_cv = ['doc', 'docx', 'pdf'];
    static $_type_import = ['xls', 'xlsx'];
    static $_type_active = ['active' => 1, 'inactive' => 2];
    static $_type_files = ['doc', 'docx', 'pdf', 'xls', 'xlsx', 'txt', 'jpeg', 'png', 'jpg'];

    public function banner()
    {
        return $this->belongsTo(Banner::class, 'obj_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'obj_id');
    }

    public function category()
    {
        return $this->belongsTo(Industry::class, 'obj_id');
    }

    public function getSizeImage($obj_type, $obj_id = null)
    {
        $size = null;
        switch ($obj_type) {
            case self::OBJ_TYPE_BANNER:
                $width = 1920;
                $height = 740;

                $m_width = 720;
                $m_height = 400;

                $banner = new Banner();
                $banner = $banner->filter(1, [
                    'relationship' => ['banner_position'],
                    'id' => $obj_id,
                ]);

                if ($banner) {
                    $width = $banner->banner_position ? $banner->banner_position->width : $width;
                    $height = $banner->banner_position ? $banner->banner_position->height : $height;

                    $m_width = $banner->banner_position ? $banner->banner_position->m_width : $m_width;
                    $m_height = $banner->banner_position ? $banner->banner_position->m_height : $m_height;
                }

                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => $width,'height' => $height],
                    'app' => ['width' => $m_width,'height' => $m_height],
                ];
                break;
            case self::OBJ_TYPE_BANNER_MOBILE:
                $width = 720;
                $height = 400;

                $banner = new Banner();
                $banner = $banner->filter(1, [
                    'relationship' => ['banner_position'],
                    'id' => $obj_id,
                ]);

                if ($banner) {
                    $width = $banner->banner_position ? $banner->banner_position->m_width : $width;
                    $height = $banner->banner_position ? $banner->banner_position->m_height : $height;
                }

                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => $width,'height' => $height],
                    'app' => ['width' => $width,'height' => $height],
                ];
                break;
            case self::OBJ_TYPE_POST:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 689,'height' => 469],
                    'app' => ['width' => 689,'height' => 469],
                ];
                break;
            case self::OBJ_TYPE_POST_VISION_MISSION:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 570,'height' => 517],
                    'app' => ['width' => 570,'height' => 517],
                ];
                break;
            case self::OBJ_TYPE_PARTNER:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 190,'height' => 190],
                    'app' => ['width' => 190,'height' => 190],
                ];
                break;
            case self::OBJ_TYPE_LOGO_HEADER:
                $size = [
                    'thumbnail' => ['width' => 65,'height' => 65],
                    'web' => ['width' => 180,'height' => 33],
                    'app' => ['width' => 180,'height' => 33],
                ];
                break;
            case self::OBJ_TYPE_LOGO_FOOTER:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 190,'height' => 32],
                    'app' => ['width' => 190,'height' => 32],
                ];
                break;
            case self::OBJ_TYPE_DIRECTOR_AVATAR:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 293,'height' => 382],
                    'app' => ['width' => 293,'height' => 382],
                ];
                break;
            case self::OBJ_TYPE_DIRECTOR_AVATAR_BIG:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 412,'height' => 329],
                    'app' => ['width' => 412,'height' => 329],
                ];
                break;
            case self::OBJ_TYPE_COMPANY:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 380,'height' => 200],
                    'app' => ['width' => 380,'height' => 200],
                ];
                break;
            case self::OBJ_TYPE_BUSINESS_AVATAR:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 65,'height' => 65],
                    'app' => ['width' => 65,'height' => 65],
                ];
                break;
            case self::OBJ_TYPE_BUSINESS_ICON:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 65,'height' => 65],
                    'app' => ['width' => 65,'height' => 65],
                ];
                break;
            case self::OBJ_TYPE_BUSINESS_ICON_ACT:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 65,'height' => 65],
                    'app' => ['width' => 65,'height' => 65],
                ];
                break;
            case self::OBJ_TYPE_BUSINESS_IMAGE:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 585,'height' => 300],
                    'app' => ['width' => 585,'height' => 300],
                ];
                break;
            case self::OBJ_TYPE_BUSINESS_IMAGE_HOME:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 665,'height' => 667],
                    'app' => ['width' => 665,'height' => 667],
                ];
                break;
            case self::OBJ_TYPE_BUSINESS_PRODUCTS_BACKGROUND:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 1920,'height' => 535],
                    'app' => ['width' => 1920,'height' => 535],
                ];
                break;
            case self::OBJ_TYPE_GROUP:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 203,'height' => 108],
                    'app' => ['width' => 203,'height' => 108],
                ];
                break;
            case self::OBJ_TYPE_MILESTONES:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 278,'height' => 210],
                    'app' => ['width' => 278,'height' => 210],
                ];
                break;
            case self::OBJ_TYPE_JOB:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 130,'height' => 130],
                    'app' => ['width' => 130,'height' => 130],
                ];
                break;
            case self::OBJ_TYPE_CORE_VALUE_AVATAR:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 1203,'height' => 400],
                    'app' => ['width' => 1203,'height' => 400],
                ];
                break;
            case self::OBJ_TYPE_CORE_VALUE_FILE:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 770,'height' => 770],
                    'app' => ['width' => 770,'height' => 770],
                ];
                break;
            case self::OBJ_TYPE_CORE_VALUE_FILE_HOW:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 406,'height' => 406],
                    'app' => ['width' => 406,'height' => 406],
                ];
                break;
            case self::OBJ_TYPE_NEWS_MEDIA:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 380,'height' => 220],
                    'app' => ['width' => 380,'height' => 220],
                ];
                break;
            case self::OBJ_TYPE_NEWS_MEDIA_DETAIL:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 718,'height' => 363],
                    'app' => ['width' => 718,'height' => 363],
                ];
                break;
            case self::OBJ_TYPE_NEWS_MEDIA_BIG:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 690,'height' => 480],
                    'app' => ['width' => 690,'height' => 480],
                ];
                break;
            case self::OBJ_TYPE_NEWS_CAROUSEL:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 480,'height' => 225],
                    'app' => ['width' => 480,'height' => 225],
                ];
                break;
            case self::OBJ_TYPE_VISION_MISSION_ACTIVE:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 70,'height' => 70],
                    'app' => ['width' => 70,'height' => 70],
                ];
                break;
            case self::OBJ_TYPE_VISION_MISSION_INACTIVE:
                $size = [
                    'thumbnail' => ['width' => 50,'height' => 50],
                    'web' => ['width' => 70,'height' => 70],
                    'app' => ['width' => 70,'height' => 70],
                ];
                break;
            default:
                break;
        }
        return $size;
    }

    public function removeFile()
    {
        try {
            $folder = public_path($this->path);
            array_map('unlink', glob("$folder*$this->name"));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function handleFile($file, $obj_id, $obj_type, $options = [])
    {
        if ($file->isValid()) {
            $extension = $file->getClientOriginalExtension();
            $public_path = '/uploads/' . $obj_type . '/' . date('YmW').'/';

            if (in_array($extension, self::$_type_cv) || in_array($extension, self::$_type_import)) {
                $name = $file->getClientOriginalName();
                $full_path = $public_path . $name;

            } else {
                $name = uniqid()."-".microtime(true).rand(10000, 99999).'.'.$extension;
                $full_path = $public_path . $name;
            }

            $destinationPath = public_path($public_path);

            if (!\File::exists($destinationPath))
                \File::makeDirectory($destinationPath, 0777, true);

            // save image
            $media = $this->newQuery()
                ->where('obj_id', $obj_id)
                ->where('obj_type', $obj_type);

            if (isset($options['locale']))
                $media = $media->where('locale', $options['locale']);

            $media = $media->first();

            if (!isset($media->id))
                $media = new Media();
            else
                $media->removeFile();

            $media->name        = $name;
            $media->obj_id      = $obj_id;
            $media->obj_type    = $obj_type;
            $media->path        = $public_path;
            $media->full_path   = $full_path;

            if (in_array($extension, self::$_type_cv) || in_array($extension, self::$_type_import)) {
                $media->type = self::_TYPE_FILE;
            } elseif (in_array($extension, self::$_type_video)) {
                $media->type = self::_TYPE_VIDEO;
            } else {
                $media->type = self::_TYPE_IMAGE;

                // remake image type only
                $sizes = $media->getSizeImage($obj_type, $obj_id);

                if(!empty($sizes)){
                    foreach ($sizes as $key => $value) {
                        $file_tmp           = $key . '_' . $name;
                        $field_path         = $key . '_path';
                        $path               = $destinationPath . $file_tmp;
                        $media->$field_path = $public_path . $file_tmp;

                        try {
                            \Image::make($file->getRealPath())->fit($value['width'], $value['height'])->save($path, 90);
                        } catch (NotSupportedException $e) {
                            return ['msg' => __('validation.mimes', ['attribute' => isset($options['key']) ? $options['key'] : '', 'values' => implode(', ', self::$_type_image)])];
                        }
                    }
                }

                $accepted_obj_types = [
                    self::OBJ_TYPE_BANNER,
                    self::OBJ_TYPE_BANNER_MOBILE,
                    self::OBJ_TYPE_CORE_VALUE_AVATAR,
                    self::OBJ_TYPE_CORE_VALUE_FILE,
                    self::OBJ_TYPE_CORE_VALUE_FILE_HOW,
                ];

                if (in_array($obj_type, $accepted_obj_types))
                    $media->locale = isset($options['locale']) ? $options['locale'] : env('APP_LOCALE');
            }

            // save DB
            $media->save();

            // move original file
            $file->move($destinationPath, $name);

            return $media;
        }

        return null;
    }

    public static function deletePublicFile($filePath = '')
    {
        if (empty($filePath)){
            return false;
        }
        try {
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        } catch (\Exception $e) {
            // do nothing
        }
        return true;
    }

    public static function uploadFileOnly($file, $obj_type, $options = [], $move = true)
    {
        $arr = [];
        if ($file->isValid()) {
            //Display File Name
            $arr['filename'] = $file->getClientOriginalName();
            //Display File Extension
            $arr['extension'] = $file->getClientOriginalExtension();
            //Display File Real Path
            $arr['realpath'] = $file->getRealPath();
            //Display File Size
            $arr['size'] = $file->getSize();
            //Display File Mime Type
            $arr['mimetype'] = $file->getMimeType();

            // rename
            if (in_array($arr['extension'], self::$_type_cv) || in_array($arr['extension'], self::$_type_import))
                $arr['newname'] = $arr['filename'];
            else
                $arr['newname'] = uniqid() . "-" . microtime(true).rand(10000,99999) . "." . $arr['extension'];

            //Move Uploaded File
            if ($move === true) {
                $public_path = '/uploads/' . $obj_type . '/' . date('YmW').'/';
                $destinationPath = public_path($public_path);
                if (!\File::exists($destinationPath))
                    \File::makeDirectory($destinationPath, 0777, true);
                try {
                    $file->move($destinationPath, $arr['newname']);
                    $arr['url'] = $public_path . "" . $arr['newname'];
                } catch (\Exception $e) {
                    // do nothing
                }
            } else {
                // do nothing
            }
        }

        return $arr;
    }

    public static function removeRecord($obj_id, $obj_type)
    {
        $data = self::query();
        $data = is_array($obj_id) ? $data->whereIn('obj_id', $obj_id) : $data->where('obj_id', $obj_id);
        $data = is_array($obj_type) ? $data->whereIn('obj_type', $obj_type) : $data->where('obj_type', $obj_type);
        $data = $data->get();

        foreach ($data as $item) {
            $item->removeFile();
            $item->delete();
        }
    }

    public static function getOneMedia($attributes = [])
    {
        $data = self::query()->where('status', Constant::STATUS_ACTIVE);

        if (isset($attributes['obj_id']) && !empty($attributes['obj_id']))
            $data = $data->where('obj_id', $attributes['obj_id']);

        if (isset($attributes['obj_type']) && !empty($attributes['obj_type']))
            $data = $data->where('obj_type', $attributes['obj_type']);

        if (isset($attributes['type']) && !empty($attributes['type']))
            $data = $data->where('type', $attributes['type']);

        if (isset($attributes['locale']) && !empty($attributes['locale']))
            $data = $data->where('locale', $attributes['locale']);

        return $data->first();
    }
}
