<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redis;
use Closure;

class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $appid = $_POST['appid'];
        $key = $_POST['key'];
        $company_id = $_POST['company_id'];

        $num_key = 'token:ip:' . $appid;
        $total = Redis::get($num_key);
        if ($total>100){
            $response = [
                'status' => 6,
                'msg'   => 'token请求次数超过限制 每天只能超过100次',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        Redis::incr($num_key);
        Redis::expire($key,86400);

        if (empty($appid) || empty($key)){
            $response = [
                'status' => 3,
                'msg'   => '缺少参数',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));

        }
//        echo date('Y-m-d H:i:s');
        $key = 'ip:' . $_SERVER['REMOTE_ADDR'] . 'company_id:' . $company_id;
        $arr = Redis::get($key);
//        var_dump($arr);
        if ($arr > 5){
            $response = [
                'errno' => 5,
                'msg'   => '超出次数限制',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        return $next($request);
    }
}
