<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

//接收数据-验证签名
    public function md5Request()
    {
        $key = "1906";    //接收端和发送端的key相同

        $data = $_GET['data'];  //接收的数据
        $sign = $_GET['sign'];  //接收的签名

        //验证签名 前提：需要与发送端使用相同的规则
        $sign2 = md5($data . $key);
        echo "接收端计算的签名:" . $sign2;

        echo "<br>";

        //与接收到的签名对比
        if ($sign2 == $sign) {
            echo "验证签名通过,数据完整";
        } else {
            echo "验证签名失败,数据损坏";
        }
    }

    //解密
    public function decrypt()
    {
        //echo 1111;
        $str = $_GET['str'];
        //$str = "h{fxvh";
        $strlen = strlen($str);
        $new_str = '';
        for ($i = 0; $i < $strlen; $i++) {
            //字母转成数字
            $ord_str = ord($str[$i]) - 3;
            $new_str .= chr($ord_str);
            echo $str[$i] . '>' . ord($str[$i]) . '>' . $ord_str . '>' . chr($ord_str);
            echo "<hr>";
        }
        echo $new_str;
    }

    //接收加密文件
    public function decrypt1(){
        $data = $_GET['data'];
        $key = '1906';
        $method = 'aes-128-cfb8';    //加算法
        $iv = 'abcdefg2qwflmnop';    //16位组成;

        $base64 =  base64_decode($data);
        echo "解密base64编码:".$base64;echo "<br>";

        $str = openssl_decrypt($base64,$method,$key,OPENSSL_RAW_DATA,$iv);
        //echo "原始数据:".$data;echo "<br>";
        echo "解密数据:".$str;echo "<br>";
    }

    //非对称解密
    public function rdecr(){
        echo "<pre>";print_r($_GET);echo "</pre>";

        $b_data=base64_decode($_GET['data']);  //base64解码
        var_dump($b_data);echo "<br>";

        $priv=file_get_contents(storage_path('key/priv.key'));
        openssl_private_decrypt($b_data,$de_data,$priv);
        var_dump($de_data);
    }
}