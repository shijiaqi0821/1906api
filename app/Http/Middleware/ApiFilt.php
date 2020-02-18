<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ApiFilt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $uri=$_SERVER['REQUEST_URI'];
        $ua=$_SERVER['HTTP_USER_AGENT'];

        //加密截取方便看
        $m_uri=substr(md5($uri),0,6);
        $m_ua=substr(md5($ua),0,6);

        //redis key
        $key="count:uri:".$m_ua.":".$m_uri;
        echo "Redis key:".$key;echo "<br>";
        echo "<br>";echo "<hr>";

        //浏览次数以及最大浏览次数
        $count=Redis::get($key);
        $max=env('API_COUNT_NUMBER');//允许访问次数

        //判断
        if($count>$max){
            echo "停止你那愚蠢的行为 充实你那无知的大脑";
            die;
        }

        Redis::incr($key);//每刷一次接口数量加1

        return $next($request);
    }
}