<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AlipayController extends Controller
{


    public function test1()
    {
        echo __METHOD__;

        $client = new Client();

        $url = 'https://openapi.alipaydev.com/gateway.do';      //沙箱环境

        //请求参数
        $common_param = [
            'out_trade_no'      => 'test1906_'.time().'_'.mt_rand(11111,99999),
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'      => '0.01',
            'subject'           => '测试订单: ' . mt_rand(11111,99999),
        ];


        $pub_param = [              //公共请求参数
            'app_id'        =>  env('ALIPAY_APPID'),
            'method'        =>  'alipay.trade.page.pay',
            'charset'       =>  'utf-8',
            'sign_type'     =>  'RSA2',
            'timestamp'     =>  date("Y-m-d H:i:s"),
            'version'       =>  '1.0',
            'biz_content'   => json_encode($common_param)
        ];


        $params = array_merge($common_param,$pub_param);
        //echo "排序前：<pre>";print_r($params);echo "</pre>";

        // 1 筛选并排序
        ksort($params);
        //echo "排序后：<pre>";print_r($params);echo "</pre>";echo '<hr>';

        // 2 拼接得到待签名字符串
        $str = "";
        foreach($params as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';        //charset=utf-8&
        }
        $str = rtrim($str,'&');
        echo "待签名字符串: " .$str;echo '<hr>';

        // 3 调用签名函数 得到签名 $sign 并 base64编码
        $priv_key_id = file_get_contents(storage_path('keys/priv_ali.key'));
        openssl_sign($str,$sign,$priv_key_id,OPENSSL_ALGO_SHA256);
        //echo "签名 sign: ".$sign;echo "<br>";
        //echo "base64: ". base64_encode($sign);
        $signature = base64_encode($sign);

        // 4 将签名加入 url参数中
        $request_url = $url .'?'. $str. '&sign='.urlencode($signature);
        echo "request_url: ".$request_url;
        header("Location:".$request_url);


    }
}
