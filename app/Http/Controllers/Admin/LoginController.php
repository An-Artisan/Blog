<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    //
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login()
    {
        if ($input = Input::all()) {
            $code = new \Code;
            $_code = $code->get();

            if (strtoupper($input['code']) != $_code) {
//                    转换成大写字母，验证码不管大小写等效
                return back()->with('msg', '验证码错误！');
//                返回错误信息
            }
            $user = User::first();
//            获取第一条数据
            if ($user->user_name != $input['user_name'] || $input['user_pass'] != ($user->user_pass)) {
                return back()->with('msg', '用户名或者密码错误！');
//                给用户提示用户名或者密码错误
            }

            session(['user' => $user]);
//            设置一个session标识
            return redirect('admin');
//            跳转到主页面

        } else {
            session(['user' => null]);
//            没数据的话就把session清空
            return view('admin.login');
//            并且返回到登陆界面
        }
    }
    public function quit()
    {
       session(['user'=>null]);
//        清空session
        return redirect('admin\login');

    }
    public function code()
    {
        $code = new \Code;
//        在根目录实例化对象
        $code->make();

    }
//    public function crypt()
//    {
//      $str = '123456';
//        $str1 = Crypt::encrypt($str);
////        echo $str1;
//        echo '<br />';
//        echo $str1;
//
//
////        密码加密
//    }
//    public function getcode()
//    {
//        $code = new \Code;
//        echo $code->get();
//
//    }
//获取到验证码
}
