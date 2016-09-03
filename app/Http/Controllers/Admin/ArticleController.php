<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get. admin/article  全部文章列表 分页功能，laravel自带的
    public function index()
    {
        $data = Article::orderBy('art_id', 'desc')->paginate(10);
        return view('admin.article.index', compact('data'));
    }

    //get. admin/article/create   添加文章
    public function create()
    {

        $data = (new Category)->tree();
//        调用分级
        return view('admin.article.add', compact('data'));
//        返回分级。

    }

    //post. admin/article    添加文章提交
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
//            新建规则，必须用系统自带的方法
        $message = [
            'art_name.required' => '文章名称不能为空！',
            'art_content.required' => '文章内容不能为空！',


//                自定义提示信息
        ];
        $validator = Validator::make($input, $rules, $message);
//            调用提示自信息，发挥给一个变量，是数组
        if ($validator->passes()) {
//                规则通过的话就执行下面的语句
            $re = Article::create($input);
            if ($re) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '分类信息更新失败，请稍后重试');
            }
//    create填充方式  必须去模版去修改$guarded =[]; 表示所有字段都能填充
        } else {
            return back()->withErrors($validator);
//                如果不符合上面的规则就提示信息到页面
        }

    }
    //get. admin/article/{article}/edit    编辑文章
    public function edit($art_id)
    {
        $data = (new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit', compact('data','field'));
    }
    //put/patch. admin/article/{category}   更新文章
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        $re = Article::where('art_id', $art_id)->update($input);
        if ($re) {
            return redirect('admin/article')->with('msg','更新文章成功！');
        } else {
            return back()->with('errors', '文章信息更新失败，请稍后重试');
        }

    }
//    delete.admin/articlde/{article}
    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '文章删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '文章删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
//    删除模板
}
