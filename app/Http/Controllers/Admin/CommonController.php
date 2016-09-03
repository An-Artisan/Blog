<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');
        if ($file ->isValid()){
//            判断文件是否有效
//            $realPath = $file->getRealPath();
//            临时文件的绝对路径
            $entension = $file ->getClientOriginalExtension();
//            上传的文件扩展名
            $newName = date('Ymdhis').mt_rand(100,900).'.'.$entension;
//            避免重命名，以当前时间，精确到秒加上三位数的随机数来命名。
            $path = $file->move(base_path().'/uploads',$newName);
//            移动文件
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
//        取文件信息

    }
    
}
