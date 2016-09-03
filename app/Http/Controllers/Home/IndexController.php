<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;


class IndexController extends CommonController
{
    //
    public function index()
    {
//        点击量最高的文章6篇
          $pics = Article::orderBy('art_view','desc')->take(6)->get();
//        take()表示要去多少数据

        $data = Article::orderBy('art_time','desc')->paginate(3);
//        中间区域
        $links = Links::orderBy('link_order','asc')->get();
//        网站的配置项
            return view('home.index',compact('pics','data','links'));
    }
    public function cate($cate_id)
    {
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
//        中间区域
        Category::where('cate_id',$cate_id)->increment('cate_view');
//        查看次数的自增,increment 自动增加1 increment('art_view',5) 自增5
//        当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();

        $field = Category::find($cate_id);
        return view('home.list',compact('field','data','submenu'));
    }
    public function article($art_id)
    {
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
//        联合查询 Join

        $article['pre']=Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
//        上一篇
        $article['next']=Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
//       下一篇
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6);
//        相关文章
        Article::where('art_id',$art_id)->increment('art_view');
//        查看次数的自增,increment 自动增加1 increment('art_view',5) 自增5
        return view('home.new',compact('field','article','data'));
    }
}

