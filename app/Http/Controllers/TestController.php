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


    /**
     * 获取当前完整URL地址
     */
    public function getUrl()
    {
        // 协议 http https
        $scheme = $_SERVER['REQUEST_SCHEME'];
        // 域名
        $host = $_SERVER['HTTP_HOST'];
        // 请求URI
        $uri = $_SERVER['REQUEST_URI'];

        $url = $scheme . '://' . $host . $uri;

        echo '当前URL: '.$url;echo '<hr>';

        echo "<pre>";print_r($_SERVER);echo "</pre>";
    }


    public function count1()
    {

        //使用UA识别用户
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $u = md5($ua);
        $u = substr($u,5,5);


        //限制 次数
        $max = env('API_ACCESS_COUNT');      //接口访问限制次数

        //判断次数是否已到上限
        $key = $u .':count1';
        echo $key;echo "<br>";
        $number = Redis::get($key);
        //var_dump($number);die;
        echo "现有访问次数：". $number;echo "<br>";


        //超过上限
        if($number > $max){
            $timeout = env('API_TIMEOUT_SECOND');      //10内禁止访问
            Redis::expire($key,$timeout);
            echo "接口访问受限，超过了访问次数" .$max;echo "<br>";
            echo "请".$timeout .' 秒后访问';echo "<br>";
            die;
        }

        //计数
        $count = Redis::incr($key);
        echo $count;echo "<br>";
        echo "访问正常";


        //限制 10秒内不能访问

    }


    public function api2()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $u = md5($ua);
        $u = substr($u,5,5);
        echo "U: ".$u;echo "<br>";

        //获取当前uri
        $uri = $_SERVER['REQUEST_URI'];
        echo "URI: ".$uri;echo "<br>";

        $md5_uri = substr( md5($uri) ,0,8);
        echo $md5_uri;echo "<br>";

        $key = 'count:uri:'.$u.':'.$md5_uri;
        echo 'Redis Key: '.$key;echo "<br>";

        echo '<hr>';
        $count = Redis::get($key);
        echo "当前接口计数： ". $count;echo "<br>";
        $max = env('API_ACCESS_COUNT');     //接口访问限制
        echo "接口访问最大次数：".$max;echo "<br>";

        if($count > $max){
           echo "你在刷接口";
           die;
        }

        Redis::incr($key);




    }


    public function api3()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $u = md5($ua);
        $u = substr($u,5,5);
        echo "U: ".$u;echo "<br>";

        //获取当前uri
        $uri = $_SERVER['REQUEST_URI'];
        echo "URI: ".$uri;echo "<br>";

        $md5_uri = substr( md5($uri) ,0,8);
        echo $md5_uri;echo "<br>";

        $key = 'count:uri:'.$u.':'.$md5_uri;
        echo 'Redis Key: '.$key;echo "<br>";

        echo '<hr>';
        $count = Redis::get($key);
        echo "当前接口计数： ". $count;echo "<br>";
        $max = env('API_ACCESS_COUNT');     //接口访问限制
        echo "接口访问最大次数：".$max;echo "<br>";

        if($count > $max){
            echo "你在刷接口";
            die;
        }

        Redis::incr($key);


    }







}
