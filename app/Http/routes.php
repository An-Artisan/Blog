<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','Home\IndexController@index');
// 前台界面
Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
//文章界面
Route::get('/a/{art_id}', 'Home\IndexController@article');
//文章界面
Route::any('admin/login', 'Admin\LoginController@login');
//登录界面
Route::get('admin/code', 'Admin\LoginController@code');
//获取验证码
Route::group(['middleware'=>'admin.login','prefix'=>'admin','namespace'=>'Admin'],function (){
//    路由分组，设置中间件，前缀，命名空间
    Route::any('/', 'IndexController@index');
//    返回index主界面
    Route::any('info', 'IndexController@info');
//    返回信息界面
    Route::any('quit', 'LoginController@quit');
//    返回退出界面
    Route::any('pass', 'IndexController@pass');
//    返回修改密码界面
    Route::post('cate/changeorder', 'CategoryController@changeOrder');
//
    Route::resource('category','CategoryController');
//    设置一个资源路由
    Route::resource('article','ArticleController');
//    设置一个资源路由
    Route::post('links/changeorder', 'LinksController@changeOrder');
//
    Route::resource('links','LinksController');
//    设置一个资源路由
    Route::post('navs/changeorder', 'NavsController@changeOrder');
//
    Route::resource('navs','NavsController');
//    设置一个资源路由
    Route::post('config/changecontent', 'ConfigController@changeContent');

    Route::get('config/putfile', 'ConfigController@putFile');

    Route::any('upload', 'CommonController@upload');
    Route::post('config/changeorder', 'ConfigController@changeOrder');

    Route::resource('config','ConfigController');
//    设置一个资源路由

});



//Route::get('admin/crypt', 'Admin\LoginController@crypt');


