<?php

namespace App\Http\Controllers;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Model\GoodsStatisticModel;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    //
    public function detail(Request $request)
    {

        $goods_id = $request->get('id');          //商品ID
        $goods_key = 'str:goods:info:'.$goods_id;
        echo 'redis_key: '.$goods_key;echo "<br>";

        //判断是否有缓存信息
        $cache = Redis::get($goods_key);

        if($cache){
            echo "有缓存：";echo "<br>";
            //var_dump($cache);
            $goods_info = json_decode($cache,true);
            echo "<pre>";print_r($goods_info);echo "</pre>";
        }else{
            echo "无缓存";echo "<br>";
           //去数据库中取数据，并保存到缓存中
            $goods_info = GoodsModel::where(['id'=>$goods_id])->first();
            //echo "<pre>";print_r($goods_info);echo "</pre>";
            $arr = $goods_info->toArray();

            $j_goods_info = json_encode($arr);
            Redis::set($goods_key,$j_goods_info);
            Redis::expire($goods_key,5);
            echo "<pre>";print_r($arr);echo "</pre>";
        }

        
        die;

        echo "goods_id:" . $goods_id;echo "<br>";
        echo "商品名：Hello World";echo '<hr>';

        $ua = $_SERVER['HTTP_USER_AGENT'];      //用于标识 UV

        $data = [
            'goods_id'  => $goods_id,
            'ua'        => $ua,
            'ip'        => $_SERVER['REMOTE_ADDR'],
        ];

        $id = GoodsStatisticModel::insertGetId($data);

        //计算统计信息
        $pv = GoodsStatisticModel::where(['goods_id'=>$goods_id])->count(); // 计算PV
        echo "当前PV: ". $pv;echo "<br>";

        // TODO laravel model 去重
        $uv = GoodsStatisticModel::where(['goods_id'=>$goods_id])->distinct('ua')->count('ua');
        echo "当前UV: ". $uv;echo "<br>";

    }
}
