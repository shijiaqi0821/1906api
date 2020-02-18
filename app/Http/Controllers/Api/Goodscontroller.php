<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsStatisticModel;

class Goodscontroller extends Controller
{
    //获取用户的pv uv ip等
    public function goods(Request $request){
        $goods_id=$request->get('id'); //获取商品id

        $goods_key="str:goods:info:".$goods_id;
        echo 'redis_key:'.$goods_key; echo "<hr>";

        //判断是否有缓存
        $cache=Redis::get($goods_key);
        if($cache){
            echo "有缓存:";echo "<hr>";
            $goods_info=json_decode($cache,true);
            print_r($goods_info);
        }else{
            echo "无缓存:";echo "<hr>";
            //取出数据库数据 保存到缓存中
            $user_info=GoodsModel::where(['id'=>$goods_id])->first();
            $json_goods=json_encode($user_info->toArray());
            Redis::set($goods_key,$json_goods);
            Redis::expire($goods_key,300);
            print_r($user_info);
        }

        die;

        $goods_name=$request->get('name');//获取商品名称
        echo "商品名称:".$goods_name; echo '<hr>';

        $ua=$_SERVER['HTTP_USER_AGENT'];

        $userInfo=[
            'goods_id'  =>$goods_id,
            'goods_name'=>$goods_name,
            'ua'         =>$ua,
            'ip'         =>$_SERVER['SERVER_ADDR']
        ];

        $id=GoodsStatisticModel::insertGetId($userInfo);
        //echo "<pre>";print_r($id);echo "</pre>";

        //计算统计信息 pv ua
        $pv=GoodsStatisticModel::where(['goods_id'=>$goods_id])->count();
        echo "当前pv浏览量:".$pv;echo "<br>";

        $uv=GoodsStatisticModel::where(['goods_id'=>$goods_id])->distinct('ua')->count('ua');
        echo "当前访客:".$uv;echo "<br>";

    }

    //限制页面的访问量
    public function number(Request $request){
        $goods_id=$request->get('id');//获取id

        $user_info=PowerModel::where(['goods_id'=>$goods_id])->first();
        print_r($user_info->toArray());

        //访问量
        Redis::setnx('num'.$goods_id,0);
        Redis::incr('num'.$goods_id);
        $num=Redis::get('num'.$goods_id);

    }
}
