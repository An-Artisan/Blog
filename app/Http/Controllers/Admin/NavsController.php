<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    //get. admin/navs  全部自定义导航列表
    public function index()
    {
        $data =Navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index',compact('data'));
    }
    public function changeOrder()
    {
        $input = Input::all();
        $navs = Navs::find($input['nav_id']);
        $navs->nav_order = $input['nav_order'];
        $re = $navs->update();
//        写入方式
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新成功！',
            ];
        } //        成功提示信息
        else {
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新失败，请稍后重试！',
            ];
        }
//        失败提示信息
        return $data;

//        echo $input['cate_id'];

    }
    //get. admin/navs/create   添加自定义导航
    public function create()
    {
        return view('admin/navs/add');

    }
    //post. admin/navs    添加自定义导航提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'nav_name' => 'required',
            'nav_url' => 'required',

        ];
//            新建规则，必须用系统自带的方法
        $message = [
            'nav_url.required' => '自定义导航Url不能为空！',
            'nav_name.required' => '自定义导航名称不能为空！',


//                自定义提示信息
        ];
        $validator = Validator::make($input, $rules, $message);
//            调用提示自信息，发挥给一个变量，是数组
        if ($validator->passes()) {
//                规则通过的话就执行下面的语句
            $re = Navs::create($input);
            if ($re) {
                return redirect('admin/navs');
            } else {
                return back()->with('errors', '自定义导航添加，清稍后重试！');
//                    否则就提示错误信息，用session来接收提示信息
            }
//    create填充方式  必须去模版去修改$guarded =[]; 表示所有字段都能填充
        } else {
            return back()->withErrors($validator);
//                如果不符合上面的规则就提示信息到页面
        }

    }
    //get. admin/navs/{navs}/edit    编辑自定义导航
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
//        取出传过来的数据
        return view('admin.navs.edit', compact('field'));
//        返回数据
    }

    //put/patch. admin/navs/{navs}   更新自定义导航
    public function update($nav_id)
    {
        $input = Input::except('_token', '_method');
        $re = Navs::where('nav_id', $nav_id)->update($input);
        if ($re) {
            return redirect('admin/navs');
        } else {
            return back()->with('errors', '自定义导航更新失败，请稍后重试');
        }
    }
    //delete. admin/navs/{navs}   删除自定义导航
    public function destroy($nav_id)
    {
        $re = Navs::where('nav_id',$nav_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '自定义导航删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '自定义导航删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //get. admin/category/{category}   显示单个分类信息
    public function show()
    {

    }
}
