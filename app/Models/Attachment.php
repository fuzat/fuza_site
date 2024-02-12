<?php

namespace App\Models;

class Attachment extends Model
{
    static $paths = [
        'product'   => 'uploads/product',
        'category'  => 'uploads/categories',
        'avatar'    => 'uploads/avatar',
        'uploads'   => 'uploads',
    ];
    static $sizes = [
        'product'   => [
            'thumbnail' => ['width' => 190,'height' => 190],
            'show'      => ['width' => 340,'height' => 304]
        ],
        'category'  => [
            'thumbnail' => ['width' => 190,'height' => 190],
            'show'      => ['width' => 355,'height' => 293]
        ],
        'avatar'  => [
            'avatar' => ['width' => 35,'height' => 35],
            'thumbnail' => ['width' => 190,'height' => 190],
        ]
    ];

    public static function showUploadFile($request, $name, $type = 'uploads')
    {
        $arr = [];
        $file = $request->file($name);
        $image = \Image::make($file->getRealPath());
        //Display File Name
        $arr['filename'] = $file->getClientOriginalName();
        //Display File Extension
        $arr['extension'] = $file->getClientOriginalExtension();
        //Display File Real Path
        $arr['realpath'] = $file->getRealPath();
        $arr['width'] = $image->width();
        $arr['height'] = $image->height();
        //Display File Size
        $arr['size'] = $file->getSize();
        //Display File Mime Type
        $arr['mimetype'] = $file->getMimeType();
        //Name
        $filename = uniqid()."_".time()."_".$file->getClientOriginalName();
        $arr['url'] = date('Y-m-d') . "+=+" . $filename;
        
        $width = $image->width();
        $height = $image->height();
        if($width >= $height && $width > 1000){
            $height = (1000 * $height) / $width;
            $width = 1000;
        }else if($height > $width && $height > 1000){
            $width = (1000 * $width) / $height;
            $height = 1000;
        }
        $dest_path = public_path(static::$paths[$type] . '/' . date('Y-m-d') . '/' );
        if(!\File::exists($dest_path))
            \File::makeDirectory($dest_path, 0777, true);

        $path = $dest_path . $filename;
        $image->resize($width, $height)->save($path, 90);
        $sizes = static::$sizes[$type];
        if(!empty($sizes)){
            foreach ($sizes as $key => $value) {
                $file_tmp = $key . '_' . $filename;
                $path = $dest_path . $file_tmp;
                \Image::make($file->getRealPath())->fit($value['width'], $value['height'])->save($path, 90);
            }    
        }
        return $arr;
    }

    public static function getDisk()
    {
        return \Storage::disk('public');
    }

    /**
     * Delete file in public folder
     */
    public static function deletePublicFile($filePath = '')
    {
        if (empty($filePath)){
            return false;
        }
        $filePath = trim($filePath, '/');
        if (file_exists(public_path($filePath))) {
            unlink($filePath);
        }
        return true;
    }

    public static function imageLink($options)
    {
        if(empty($options['name'])){
            return '';
        }
        $img['path'] = static::$paths[$options['type']];
        list($date, $name) = explode('+=+', $options['name']);
        $img['date'] = $date;
        if (!empty($options['size'])){
            $img['image'] = $options['size'] . '_' . $name;
        } else {
            $img['image'] = $name;
        }
        return implode('/', [$img['path'], $img['date'], $img['image']]);
    }
}
