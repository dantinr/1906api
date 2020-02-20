<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/phpinfo',function(){
    phpinfo();
});


###############  测试 路由 #########################


Route::prefix('/test')->group(function(){
    Route::get('/redis','TestController@testRedis');
    Route::get('/test002','TestController@test002');
    Route::get('/test003','TestController@test003');
    Route::get('/wx/token','TestController@getAccessToken');
    Route::get('/curl1','TestController@curl1');
    Route::get('/curl2','TestController@curl2');
    Route::get('/guzzle1','TestController@guzzle1');

    Route::get('/get1','TestController@get1');      // 处理get请求的接口
    Route::post('/post1','TestController@post1');      // 处理post请求的接口
    Route::post('/post2','TestController@post2');      // 处理post请求的接口
    Route::post('/post3','TestController@post3');      // 处理post请求的接口

    Route::post('/upload','TestController@testUpload');      // 处理post上传文件
    Route::get('/get/url','TestController@getUrl');

    Route::get('/redis/str1','TestController@RedisStr1');

    Route::get('/redis/count1','TestController@count1');
    Route::get('/api2','TestController@api2');
    Route::get('/api3','TestController@api3');
    Route::get('/api3','TestController@api3');
    Route::get('/api3','TestController@api3');
    Route::get('/api3','TestController@api3');
    Route::get('/md5test1','TestController@md5Test1');
    Route::get('/verify','TestController@verifySign');
});

###############  测试 路由 #########################



Route::prefix('/api')->group(function(){
    Route::get('/user/info','Api\UserController@info');
    Route::post('/user/reg','Api\UserController@reg');          // 用户注册


    Route::get('/weather','Api\UserController@weather');        //获取天气


});


Route::get('/goods','GoodsController@detail');      //商品详情








