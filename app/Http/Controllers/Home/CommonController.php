<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    //
    public function __construct()
//        __construct 会自动执行这个函数
    {
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
//        点击排行
        $new = Article::orderBy('art_time','desc')->take(8)->get();
//        友情链接
       $navs = Navs::all();
        View::share('new',$new);
        View::share('hot',$hot);
        View::share('navs',$navs);

//        共享到继承commonController的控制器。其他页面可以直接用这个变量
    }
}
