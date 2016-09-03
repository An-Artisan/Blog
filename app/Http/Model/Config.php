<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $table='config';
//    设置数据库名
    protected $primaryKey='conf_id';
//    设置主键
    public $timestamps=false;
//    不需要系统自带的两个字段
    protected $guarded=[];
//    表示任何字段都能用create填充
}
