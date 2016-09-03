<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class CategoryController extends CommonController
{
    //get. admin/category  全部分类列表
    public function index()
    {
//        $categorys =  Category::tree();
        $categorys = (new Category)->tree();

//        获取所有数据


        return view('admin.category.index')->with('data', $categorys);
//        返回到视图
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
//        写入方式
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功',
            ];
        } //        成功提示信息
        else {
            $data = [
                'status' => 0,
                'msg' => '分类排序更新失败，清稍后重试',
            ];
        }
//        失败提示信息
        return $data;

//        echo $input['cate_id'];

    }

    //get. admin/category/create   添加分类
    public function create()
    {
        $data = Category::where('cate_pid', 0)->get();
        return view('admin/category/add', compact('data'));

    }

    //post. admin/category    添加分类提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'cate_name' => 'required',
        ];
//            新建规则，必须用系统自带的方法
        $message = [
            'cate_name.required' => '分类名称不能为空！',

//                自定义提示信息
        ];
        $validator = Validator::make($input, $rules, $message);
//            调用提示自信息，发挥给一个变量，是数组
        if ($validator->passes()) {
//                规则通过的话就执行下面的语句
            $re = Category::create($input);
            if ($re) {
                return redirect('admin/category');
            } else {
                return back()->with('errors', '数据填充失败，清稍后重试！');
//                    否则就提示错误信息，用session来接收提示信息
            }
//    create填充方式  必须去模版去修改$guarded =[]; 表示所有字段都能填充
        } else {
            return back()->withErrors($validator);
//                如果不符合上面的规则就提示信息到页面
        }
    }

    //get. admin/category/{category}/edit    编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
//        取出传过来的数据
        $data = Category::where('cate_pid', 0)->get();
//        返回pid
        return view('admin.category.edit', compact('field', 'data'));
//        返回数据
    }

    //put/patch. admin/category/{category}   更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token', '_method');
        $re = Category::where('cate_id', $cate_id)->update($input);
        if ($re) {
            return redirect('admin/category');
        } else {
            return back()->with('errors', '分类信息更新失败，请稍后重试');
        }
    }


    //get. admin/category/{category}   显示单个分类信息
    public function show()
    {

    }

    //delete. admin/category/{category}   删除单个分类
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id',$cate_id)->delete();

        if($re){
            $data = [
                'status' => 0,
                'msg' => '分类删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类删除失败，请稍后重试！',
            ];
        }
        return $data;
    }


}
