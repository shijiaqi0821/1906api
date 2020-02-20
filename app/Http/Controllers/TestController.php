<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller{

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
}
