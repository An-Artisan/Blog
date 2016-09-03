<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table='category';
//    设置数据库名
    protected $primaryKey='cate_id';
//    设置主键
    public $timestamps=false;
//    不需要系统自带的两个字段
    protected $guarded=[];
//    表示任何字段都能用create填充
    public  function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
//        获取所有数据
        return $this->getTree($categorys,'cate_name','cate_id','cate_pid',0);
//        调用分级
}
//    public static function tree()
//    {
//        $categorys = Category::all();
////        获取所有数据
//        return (new Category)->getTree($categorys,'cate_name','cate_id','cate_pid',0);
////        调用分级
//    }
////    第二种方法，实例化类和使用静态方法
    public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {       $arr = array();
//        定义一个空数组
        foreach ($data as $k=>$v){
//                循环数组
            if ($v->$field_pid == $pid){
                $arr[] = $data[$k];
//                    为0的cate_id的一级分类
                foreach ($data as $m=>$n){
//                        在调用循环
                    if ($n->$field_pid == $v->$field_id){
                        $str=$data[$m][$field_name] ;
                        $data[$m][$field_name]='┝┉┉'.$str;
//                            给二级分类加一点样式。好分别
                        $arr[]=$data[$m];
//                            如果cate_pid==cate_id的话就赋值给数组，达到二级分类的目的

                    }
                }
            }
        }
        return $arr;
//        返回到调用函数
    }
}
