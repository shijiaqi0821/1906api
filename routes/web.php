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

Route::get('/phpinfo', function () {
    phpinfo();
});


//关于用户
Route::prefix('test')->group(function () {
    Route::any('/','Api\Testcontroller@one');//获取用户信息
    Route::any('/two','Api\Testcontroller@two');//用户注册
});
//获取天气信息
Route::prefix('weather')->group(function () {
    Route::any('/','Api\Testcontroller@weather');
});
//##########################

Route::get('/md2','TestController@md5Request'); //接收端
//解密
Route::get('/decrypt','TestController@decrypt');

Route::get('/decrypt1','TestController@decrypt1');
//非对称解密
Route::get('/rdecr','TestController@rdecr');
//非对称jia密2
Route::get('/rdecr2','TestController@rdecr2');

Route::get('/rsaVerify','TestController@rsaVerify');

//alipay
Route::get('/alipay','Alipaycontroller@Alipay');

//##########################
//test测试 路由分组
Route::prefix('/test')->group(function(){
    Route::get('/redis','Api\Testcontroller@testRedis');
    Route::get('/aaa','Api\Testcontroller@testaaa');
    Route::get('/access','Api\Testcontroller@getAccessToken'); //获取用户accesstoken
    Route::get('/curl','Api\Testcontroller@curl1'); //curl
    Route::get('/curl2','Api\Testcontroller@curl2'); //curl
    Route::get('/guzzle','Api\Testcontroller@guzzle1'); //guzzle
    Route::get('/guzzle2','Api\Testcontroller@guzzle2'); //guzzle

    Route::get('/get1','Api\Testcontroller@get1');  //处理get的请求接口
    Route::post('/post1','Api\Testcontroller@post1');  //处理post的请求接口
    Route::post('/post2','Api\Testcontroller@post2');  //处理post的请求接口
    Route::post('/post3','Api\Testcontroller@post3');  //处理post的请求接口

    Route::post('/upload','Api\Testcontroller@upload');  //处理post上传文件
    Route::get('/getHttp','Api\Testcontroller@http');  //获取当前完整的url地址
    Route::get('/str','Api\Testcontroller@redisStr');  //获取当前完整的url地址

    Route::get('/redis/count1','Api\Testcontroller@count'); //访问量的操作
    Route::get('/url1','Api\Testcontroller@url1'); //每个页面的限制访问
    Route::get('/url2','Api\Testcontroller@url2'); //每个页面的限制访问
});

Route::prefix('/guzzle')->group(function(){
    Route::get('guzzle','Api\Testcontroller@guzzleGet');  //guzzle的get请求
    Route::post('guzzle1','Api\Testcontroller@guzzlePost');  //guzzle的post请求
    Route::post('guzzleUpload','Api\Testcontroller@guzzleUpload'); //文件上传 post形式
});


//获取用户的pv uc ip等
Route::prefix('/goods')->group(function(){
    Route::get('/goods','Api\Goodscontroller@goods');
    Route::get('/number','Api\Goodscontroller@number');
});


