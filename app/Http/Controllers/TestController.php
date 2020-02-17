<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use GuzzleHttp\Client;

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


    /**
     * 获取微信 access_token
     */
    public function getAccessToken()
    {
        $app_id = 'wx86737d80f8dac5c9';
        $appsecret = '7c5deccfb30731052d11734a6d21f5a0';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret;
        echo $url;echo '<hr>';
        //使用 file_get_contents 发起GET请求
        $response = file_get_contents($url);
        var_dump($response);echo '<hr>';
        $arr = json_decode($response,true);
        //echo "<pre>";print_r($arr);echo "</pre>";
    }

    public function curl1()
    {
        $app_id = 'wx86737d80f8dac5c9';
        $appsecret = '7c5deccfb30731052d11734a6d21f5a0';
        $url = 'https://api.weixin.qq1.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret;
        //echo $url;echo '<hr>';

        // 初始化
        $ch = curl_init($url);

        //设置参数选项
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);   //0启用浏览器输出 1 关闭浏览器输出，可用变量接收响应

        //执行会话
        $response = curl_exec($ch);

        //关闭会话
        curl_close($ch);

        //处理错误
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if($errno > 0)      //有问题
        {
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：". $error;die;
            die;
        }

        // 处理逻辑
        var_dump($response);

    }

    /**
     * curl post请求
     */
    public function curl2()
    {

        $access_token = '30_keKFvkByUYlr5jtiu8leOzO4pimRGB5XySMoXFzB9182sswqDLQbGqEvAPN-1XfgMxBHfhFGjKygwrf0WWpvUxo5gw9X1BbPayPLRI2roKi6GdRmr-c3nZKmkuW5OVhjZRKiNftcaMoB9oCSDJKiAIAMST';
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;

        $menu = [
            "button"    => [
                [
                    "type"  => "click",
                    "name"  => "CURL",
                    "key"   => "curl001"
                ]
            ]
        ];


        // 初始化
        $ch = curl_init($url);

        //设置参数
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
        // POST请求
        curl_setopt($ch,CURLOPT_POST,true);
        // 发送json数据 非form-data形式
        curl_setopt($ch, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($menu));


        //执行curl会话
        $response = curl_exec($ch);

        //捕获错误
        //处理错误
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if($errno > 0)      //有问题
        {
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：". $error;die;
            die;
        }


        //关闭会话
        curl_close($ch);



        //数据处理
        var_dump($response);




    }



    public function guzzle1()
    {
        $app_id = 'wx86737d80f8dac5c9';
        $appsecret = '7c5deccfb30731052d11734a6d21f5a0';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret;
        //echo $url;echo '<hr>';

        $client = new Client();
        $response = $client->request('GET',$url);
        $data = $response->getBody();           //获取服务端响应的数据
        echo $data;

        //guzzle post

    }

    public function get1()
    {
        echo "接收到的数据：";echo "<br>";
        echo "<pre>";print_r($_GET);echo "</pre>";
    }

    public function post1()
    {
        echo '<hr>';
        echo "我是API 开始";
        echo "<pre>";print_r($_POST);echo "</pre>";
        echo "<pre>";print_r($_FILES);echo "</pre>";
        echo "我是API 结束";
    }

    public function post2()
    {
        echo "<pre>";print_r($_POST);echo "</pre>";
    }

    /**
     * 接收 json xml
     */
    public function post3()
    {
        $data = file_get_contents("php://input");
        echo $data;echo '<hr>';

        $arr = json_decode($data,true);
        echo "<pre>";print_r($arr);echo "</pre>";

    }


    /**
     * 接收post 上传文件
     */
    public function testUpload()
    {
        echo "<pre>";print_r($_POST);echo "</pre>";
        echo "接收文件：";echo "<br>";
        echo "<pre>";print_r($_FILES);echo "</pre>";
    }











}
