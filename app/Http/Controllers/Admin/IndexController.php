<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;


use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{

    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function pass()
    {
        if ($input = Input::all()) {
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
//            新建规则，必须用系统自带的方法
            $message = [
                'password.required' => '新密码不能为空',
                'password.between' => '新密码必须在6到20位之间！',
                'password.confirmed' => '新密码与确定密码不一致！',
//                自定义提示信息
            ];
            $validator = Validator::make($input, $rules, $message);
//            调用提示自信息，发挥给一个变量，是数组
            if ($validator->passes()) {
//                规则通过的话就执行下面的语句
                $user = User::first();
//                  获取第一条数据
                $_password = $user->user_pass;
//                  获取密码
                if ($_password == $input['password_o']) {
//                    判断输入的密码和原始密码是否相同
                    $user->user_pass = $input['password'];
//                   相同的话就更改新密码
                    $user->update();
//                    更新

                    return back()->with('errors', '密码修改成功！');
//                    同时跳转到另外的目录
                } else {
                    return back()->with('errors', '原密码错误！');
//                    否则就提示错误信息，用session来接收提示信息
                }
            } else {
                return back()->withErrors($validator);
//                如果不符合上面的规则就提示信息到页面

            }
        } else {
//            如果没有数据，代表通过get方式的请求，就放回到修改密码界面
            return view('admin.pass');
        }
    }
//更改超级管理员密码


}
