<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //get. admin/links  全部友情链接列表
    public function index()
    {
        $data =Links::orderBy('link_order','asc')->get();
        return view('admin.links.index',compact('data'));
    }
    public function changeOrder()
    {
        $input = Input::all();
        $links = Links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $re = $links->update();
//        写入方式
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功！',
            ];
        } //        成功提示信息
        else {
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新失败，请稍后重试！',
            ];
        }
//        失败提示信息
        return $data;

//        echo $input['cate_id'];

    }
    //get. admin/links/create   添加友情链接
    public function create()
    {
        return view('admin/links/add');

    }
    //post. admin/links    添加友情链接提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required',

        ];
//            新建规则，必须用系统自带的方法
        $message = [
            'link_url.required' => '友情链接Url不能为空！',
            'link_name.required' => '友情链接名称不能为空！',


//                自定义提示信息
        ];
        $validator = Validator::make($input, $rules, $message);
//            调用提示自信息，发挥给一个变量，是数组
        if ($validator->passes()) {
//                规则通过的话就执行下面的语句
            $re = Links::create($input);
            if ($re) {
                return redirect('admin/links');
            } else {
                return back()->with('errors', '友情链接添加，清稍后重试！');
//                    否则就提示错误信息，用session来接收提示信息
            }
//    create填充方式  必须去模版去修改$guarded =[]; 表示所有字段都能填充
        } else {
            return back()->withErrors($validator);
//                如果不符合上面的规则就提示信息到页面
        }

    }
    //get. admin/links/{links}/edit    编辑友情链接
    public function edit($link_id)
    {
        $field = Links::find($link_id);
//        取出传过来的数据
        return view('admin.links.edit', compact('field'));
//        返回数据
    }

    //put/patch. admin/links/{links}   更新友情链接
    public function update($link_id)
    {
        $input = Input::except('_token', '_method');
        $re = Links::where('link_id', $link_id)->update($input);
        if ($re) {
            return redirect('admin/links');
        } else {
            return back()->with('errors', '友情链接更新失败，请稍后重试');
        }
    }
    //delete. admin/links/{links}   删除友情链接
    public function destroy($link_id)
    {
        $re = Links::where('link_id',$link_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //get. admin/category/{category}   显示单个分类信息
    public function show()
    {

    }
}
