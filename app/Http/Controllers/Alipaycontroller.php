<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Alipaycontroller extends Controller
{
    //支付宝接口的调用
    public function Alipay(){

        $client= new Client();
        //沙箱环境
        $url="https://openapi.alipaydev.com/gateway.do";

        //请求参数
        $common_param=[
            'out_trade_no'  =>'test1906_'.time().'_'.mt_rand(11111,99999),
            'product_code'  =>'FAST_INSTANT_TRADE_PAY',
            'total_amount'  =>'0.01',
            'subject'        =>'测试订单:'.mt_rand(11111,99999),
        ];

        //公共请求参数
        $pub_param=[
            'app_id'        =>env('ALIPAY_APPID'),
            'method'        =>'alipay.trade.page.pay',
            'charset'       =>'utf-8',
            'sign_type'     =>'RSA2',
            'timestamp'     =>date("Y-m-d H:i:s"),
            'version'       =>'1.0',
            'biz_content'  =>json_encode($common_param)
        ];

        $params=array_merge($common_param,$pub_param);
        echo "排序前: <pre>";print_r($params);echo "</pre>";

        //筛选并排序
        ksort($params);
        echo "排序后: <pre>";print_r($params);echo "</pre>";echo "<hr>";

        //拼接得到待签名字符串
        $str='';
        foreach($params as $k=>$v){
            $str.=$k.'='.$v.'&';
        }
        $str=rtrim($str,'&');
        echo "待签名字符串:".$str;echo "<hr>";

        //调用签名函数  得到签名$sign  并base64编码
        $priv_key_id=file_get_contents(storage_path('key/priv_ali.key'));
        openssl_sign($str,$sign,$priv_key_id,OPENSSL_ALGO_SHA256);
        echo "签名 sign:".$sign;echo "<br>";
        echo "base64:".base64_encode($sign);
        $signtrue=base64_encode($sign);

        //将签名加入url参数中
        $request_url=$url.'?'.$str.'&sign='.urlencode($signtrue);
        echo "request_url:".$request_url;

        header("Location:".$request_url);
    }
}
