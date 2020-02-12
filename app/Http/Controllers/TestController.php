<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    //

    public function testRedis()
    {
        $key = '1906';
        $val = time();
        Redis::set($key,$val);       // set 一个 键 并赋值
        $value = Redis::get($key);      // 获取 key 的值
        echo 'value: '.$value;

    }

    public function test002()
    {
        echo "Hello World 111";
    }


    public function test003()
    {

        $user_info = [
            'user_name' => 'zhangsan',
            'email'     => 'zhangsan@qq.com',
            'age'       => 11
        ];

        echo json_encode($user_info);


    }
}
