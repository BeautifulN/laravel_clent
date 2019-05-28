<?php

namespace App\Http\Controllers\Dome;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurlController extends Controller
{
    public function mycurl($url,$method,$type)
    {
        $ch = curl_init($url);

        curl_setopt($ch,CURLOPT_URL,$url);

        if ($method == 1){ //get
            curl_setopt($ch,CURLOPT_HEADER,0);

            //抓取URL并把他传递为浏览器
            $rs = curl_exec($ch);
            $code = curl_errno($ch);
            var_dump($code);

            //关闭curl资源，并释放系统内存
            curl_close($ch);
            var_dump($rs);

        }else{            //post

            curl_setopt($ch,CURLOPT_POST,1);
            //发送数据
            curl_setopt($ch,CURLOPT_POSTFIELDS,$type);
            //禁止浏览器输出，用变量接收
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //抓取URL并传给浏览器
            $data = curl_exec($ch);
            echo $data;
            //关闭curl资源，并释放系统内存
            curl_close($ch);
        }
    }
}
