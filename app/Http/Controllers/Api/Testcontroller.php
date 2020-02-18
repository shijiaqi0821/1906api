<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\UserModel;
use GuzzleHttp\Client;

class Testcontroller extends Controller
{
    //用户信息
    public function one(){
        $into=[
            'name'=>"sjq",
            'age'=>'20',
            'time'=>date('Y-m-d H:i:s')
        ];
        return $into;
    }
    //用户注册
    public function two(Request $request){
        $user_info = [
            'user_name'=>$request->input('user_name'),
            'email'=>$request->input('email'),
            'pass'=>'123456',
            ];
        //入库
        $id = UserModel::insertGetId($user_info);
        echo "自增ID:".$id;
    }

    //获取用户的access_token
    public function getAccessToken(){
        $appid='wxc22a745cff2aeda7';
        $appsecret='3b68d4ba77ae8c12d04e57bd57e8ffc9';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        echo $url;
        echo "<hr>";
        //使用file_get_contents发起get请求
        $res=file_get_contents($url);
        var_dump($res);
        echo "<hr>";
        $arr=json_decode($res,true);
        print_r($arr);
    }

    public function curl1(){
        $appid='wxc22a745cff2aeda7';
        $appsecret='3b68d4ba77ae8c12d04e57bd57e8ffc9';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        echo $url;
        echo"<hr>";

        //初始化
        $ch=curl_init($url);

        //设置参数选项
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ; //0启用浏览器输出  1 关闭浏览器输出  可用变量接收响应

        //执行会话
        $data=curl_exec($ch);

        //捕获并处理错误
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        if($errno>0){   //错误码为0则是不报错
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息:".$error;die;
            die;
        }

        //关闭会话
        curl_close($ch);

        //echo "服务器响应的数据:";echo '<br>';
        //echo $data;echo "<hr>";

        //$arr=json_decode($data,true);
        //print_r($arr);
    }

    //curl post请求
    public function curl2(){
        $access_token='30_TnoJ-AVElPLKOIgUW71nVlsSEQXBYEaodR64Wxu6wH88alveviGWtUiS6dENQ14K1kHGgX9TGiflo9zKM9_hXRhAibhOSV2auGopwv09NLjnbsm9iPBmeUyU6mysvXFxDGQC0orXdvNqMqT2NPSiAGAWYB';
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;

        $menu=[
            "button"=>[
                [
                    "type"=>"click",
                    "name"=>"CURL",
                    "key"=>"curl101"
                ]
            ]
        ];

        //初始化
        $ch=curl_init($url);

        //设置参数选项
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ; //0启用浏览器输出  1 关闭浏览器输出  可用变量接收响应
        //post请求
        curl_setopt($ch,CURLOPT_POST,true);
        //发送json数据 非form-data形式
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type：application/json']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($menu));

        //执行会话
        $data=curl_exec($ch);

        //捕获并处理错误
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        if($errno>0){   //错误码为0则是不报错
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息:".$error;die;
            die;
        }
        //关闭会话
        curl_close($ch);
        //数据处理
        var_dump($data);
    }
    /***********/
    //guzzle get额请求
    public function guzzle1(){
        $appid='wxc22a745cff2aeda7';
        $appsecret='3b68d4ba77ae8c12d04e57bd57e8ffc9';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        echo $url;
        echo"<hr>";

        $client=new client();
        $response=$client->request('GET',$url);
        $res=$response->getBody();  //获取服务端的响应
        echo $res;
    }

    //guzzle  post  请求
    public function guzzle2(){
        $access_token='30_TnoJ-AVElPLKOIgUW71nVlsSEQXBYEaodR64Wxu6wH88alveviGWtUiS6dENQ14K1kHGgX9TGiflo9zKM9_hXRhAibhOSV2auGopwv09NLjnbsm9iPBmeUyU6mysvXFxDGQC0orXdvNqMqT2NPSiAGAWYB';
        $url="https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=".$access_token;

        $client=new client();
        $response = $client->post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['token' => 'foo']
        ]);

        //$response=$client->request('POST',$url);
        $res=$response->getBody();  //获取服务端的响应
        echo $res;

    }

    //处理get请求的接口
    public function get1(){
        echo "<pre>";print_r($_GET);echo "</pre>";
    }

    //处理post请求的接口
    public function post1(){
        echo '<hr>';
        echo "我是开始 API";
        echo"<pre>";print_r($_POST);echo "</pre>";
        echo "我是结束 API";
    }

    public function post2(){
        echo "<pre>";print_r($_POST);echo "</pre>";
    }

    public function post3(){
        $data=file_get_contents("php://input");  //接收json或者xml字符串
        echo $data;echo '<hr>';

        $arr=json_decode($data,true);
        echo "<pre>";print_r($arr);echo "</pre>";
    }

    //接收post 上传文件
    public function upload(){
        echo "<pre>";print_r($_POST);echo "</pre>";
        echo "接收文件：";echo "<hr>";
        echo "<pre>";print_r($_FILES);echo "</pre>";
    }

    //guzzle的get请求
    public function guzzleGet(){
        echo "接收到的数据：";echo "<hr>";
        echo "<pre>";print_r($_GET);echo "</pre>";
    }

    //guzzle的post请求
    public function guzzlePost(){
        echo "<hr>";
        echo "我是API的开始";echo "<br>";
        echo "接收的数据：";echo "<br>";
        echo "<pre>";print_r($_POST);echo "</pre>";
        echo "我是API的结束";
        echo "<hr>";
    }


    //文件上传
    public function guzzleUpload(){
        echo "<hr>";
        echo "我是API的开始";echo "<br>";
        echo "接收的数据是：";echo "<br>";
        echo "<pre>";print_r($_POST);echo "</pre>";
        echo "上传的文件是：";echo "<br>";
        echo "<pre>";print_r($_FILES);echo "</pre>";
        echo "我是API的结束";
        echo "<hr>";
    }

    //获取当前的完整的url地址
    public function http(){
        $http=$_SERVER['REQUEST_SCHEME'];  //获取协议
        //echo $http;echo '<br>';

        $host=$_SERVER['HTTP_HOST'];//获取host
        //echo $host;echo '<br>';

        $uri=$_SERVER['REQUEST_URI'];//获取资源路径
        //echo $uri;echo '<br>';

        //完整的路径
        $url=$http.'://'.$host.$uri;
        echo "当前url:".$url;echo '<br>';

        echo "<pre>";print_r($_SERVER);echo "</pre>";
    }

    public function redisStr(){
        $key='age';
        $val='19';

        //写入值
        Redis::set($key,$val);//等价于 set name lisi

        //设置过期时间
        Redis::expire($key,300);
    }

    //*****************************************
    //访问量
    public function count(){
        //使用ua辨别用户
        $ua=$_SERVER['HTTP_USER_AGENT'];
        $u=md5($ua); //加密让ua变短
        $u=substr($u,6,6); //截取其中一段

        //允许访问次数
        $count=env('API_COUNT_NUMBER');
        // echo $count;die;

        //判断访问次数是否已到上限
        $key=$u .':count';
        $number=Redis::get($key);
        echo "现访问次数:".$number;
        echo "<br>";

        //超过上限
        if($number>$count){
            $timeout=env('API_TIMEOUT_MIN');
            Redis::expire($key,$timeout);
            echo "接口访问受限,已超过访问次数";echo "<br>";
            echo "请".$timeout."秒后访问";echo "<br>";
            die;
        }

        //已访问次数
        $num=Redis::incr($key);
        echo $num;echo '<hr>';
        echo "访问正常";

    }

    //每个接口
    public function url1(){
        $ua=$_SERVER['HTTP_USER_AGENT']; //用户ua
        $u=md5($ua); //加密让ua变短
        $u=substr($u,6,8); //截取其中一段
        echo "用户的UA:".$u;echo "<br>";

        //获取当前的uri
        $uri=$_SERVER['REQUEST_URI'];
        echo "URI为:".$uri;echo "<br>";

        $uriMd5=substr(md5($uri),0,6);
        echo $uriMd5;echo "<br>";

        $key="count:uri:".$u.":".$uriMd5;
        echo "Redis key:".$key;echo "<br>";
        echo "<br>";echo "<hr>";

        $count=Redis::get($key);
        echo "当前接口的访问数量:".$count;echo "<br>";
        $max=env('API_COUNT_NUMBER');//允许访问次数
        echo "接口访问的最大次数:".$max;echo "<br>";

        //判断
        if($count>$max){
            echo "一直刷什么接口！！！";
            die;
        }

        Redis::incr($key);//每刷一次接口数量加1
    }

    //每个接口
    public function url2(){
        $ua=$_SERVER['HTTP_USER_AGENT']; //用户ua
        $u=md5($ua); //加密让ua变短
        $u=substr($u,6,8); //截取其中一段
        echo "用户的UA:".$u;echo "<br>";

        //获取当前的uri
        $uri=$_SERVER['REQUEST_URI'];
        echo "URI为:".$uri;echo "<br>";

        $uriMd5=substr(md5($uri),0,6);
        echo $uriMd5;echo "<br>";

        $key="count:uri:".$u.":".$uriMd5;
        echo "Redis key:".$key;echo "<br>";
        echo "<br>";echo "<hr>";

        $count=Redis::get($key);
        echo "当前接口的访问数量:".$count;echo "<br>";

        //允许访问次数
        $max=env('API_COUNT_NUMBER');
        echo "接口访问的最大次数:".$max;echo "<br>";

        //判断
        if($count>$max){
            echo "一直刷什么接口....";
            die;
        }

        Redis::incr($key);//每刷一次接口数量加1
    }
}
