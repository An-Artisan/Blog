<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get. admin/config  全部配置项列表
    public function index()
    {
        $data =Config::orderBy('conf_order','asc')->get();

        foreach ($data as $k => $v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type = "text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //格式 1|开启,0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach ($arr as $m => $n){
                        $r = explode('|',$n);
                        $c = $v->conf_content == $r[0]?' checked  ':'';
                        $str .='<input type = "radio" name = "conf_content[]" value ="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }

        return view('admin.config.index',compact('data'));
    }

    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
//            表示conf_id为$v的记录更新conf_content字段
        }
        $this->putFile();
        return back()->with('errors', '配置项更新成功！');
    }

    public function putFile()
    {
        $config = Config::pluck('conf_content','conf_name')->all();
//        pluck过滤数据 是一个数组 all()方式取出纯净数据
//        吧数组转换字符串
        $path = base_path().'\config\web.php';
        //        base_path 根目录
        $str = '<?php return '.var_export($config,true).';';
//        写入config文件
        file_put_contents($path,$str);
//   file_put_contents($path,$content);写入文件数据
    }
    public function changeOrder()
    {
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $re = $config->update();
//        写入方式
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功！',
            ];
        } //        成功提示信息
        else {
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新失败，请稍后重试！',
            ];
        }
//        失败提示信息
        return $data;

//        echo $input['cate_id'];

    }
    //get. admin/config/create   添加配置项
    public function create()
    {
        return view('admin/config/add');

    }
    //post. admin/config    添加配置项提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name' => 'required',
            'conf_title' => 'required',

        ];
//            新建规则，必须用系统自带的方法
        $message = [
            'conf_title.required' => '配置项标题不能为空！',
            'conf_name.required' => '配置项名称不能为空！',


//                自定义提示信息
        ];
        $validator = Validator::make($input, $rules, $message);
//            调用提示自信息，发挥给一个变量，是数组
        if ($validator->passes()) {
//                规则通过的话就执行下面的语句
            $re = Config::create($input);
            if ($re) {
                return redirect('admin/config');
            } else {
                return back()->with('errors', '配置项失败，请稍后重试！');
//                    否则就提示错误信息，用session来接收提示信息
            }
//    create填充方式  必须去模版去修改$guarded =[]; 表示所有字段都能填充
        } else {
            return back()->withErrors($validator);
//                如果不符合上面的规则就提示信息到页面
        }

    }
    //get. admin/config/{config}/edit    编辑配置项
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
//        取出传过来的数据
        return view('admin.config.edit', compact('field'));
//        返回数据
    }

    //put/patch. admin/config/{config}   更新配置项
    public function update($conf_id)
    {
        $input = Input::except('_token', '_method');
        $re = Config::where('conf_id', $conf_id)->update($input);
        if ($re) {
            $this->putFile();
            return redirect('admin/config');
        } else {
            return back()->with('errors', '配置项更新失败，请稍后重试');
        }
    }
    //delete. admin/config/{config}   删除配置项
    public function destroy($conf_id)
    {
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '配置项删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //get. admin/category/{category}   显示单个分类信息
    public function show()
    {

    }
}
