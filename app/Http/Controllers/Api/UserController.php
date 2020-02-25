<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\UserModel;

class UserController extends Controller
{

    /**
     * 获取用户信息
     * 2020年2月12日10:04:22
     */
    public function info()
    {
        $user_info = [
            'user_name' => 'zhangsan',
            'sex'       => 1,
            'email'     => 'zhangsan@qq.com',
            'age'       => 11,
            'date'      => date('Y-m-d H:i:s')
        ];

        return $user_info;

    }

    /**
     * 用户注册
     * 2020年2月12日10:36:36
     */
    public function reg(Request $request)
    {

        $user_info = [
            'user_name' => $request->input('user_name'),
            'email'     => $request->input('email'),
            'pass'      => '123456abc',
        ];

        //入库
        $id = UserModel::insertGetId($user_info);

        echo "自增ID: ".$id;

    }


    /**
     * 获取天气
     * 2020年2月20日14:54:57
     */
    public function weather()
    {

        if(empty($_GET['location'])){
            echo "请输入地理位置";die;
        }

        $location = $_GET['location'];     //客户端传递的参数
        //请求第三方 天气接口
        $url = 'https://free-api.heweather.net/s6/weather/now?location='.$location.'&key=d957029d5931428f8eef6ba241aefdd7';
        $data = file_get_contents($url);
        $arr = json_decode($data,true);
        echo "<pre>";print_r($arr);echo "</pre>";echo '<hr>';

        return $arr;
    }
}
