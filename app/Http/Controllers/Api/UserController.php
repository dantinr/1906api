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
}
