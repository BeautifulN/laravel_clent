<?php

namespace App\Http\Controllers\Dome;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SslController extends Controller
{
    public function lists(){
        return view('ssl.lists');
    }

    public function ssl(Request $request)  //对称加密
    {
        $pass= $request->input('password');
        $method = 'AES-256-CBC';   //加密的方式
        $key = '123456';    //密钥
        $option = OPENSSL_RAW_DATA;  //格式
        $iv = '123456qazwsx9876';  //必须为16位
        $newPass=openssl_encrypt($pass,$method,$key,$option,$iv); //加密
//        print_r($newPass);
        $arr = base64_encode($newPass);  //base64加密
//        print_r($arr);

//        $url='http://www.jd.com/';
        $url='http://lumen_1809a.com/save';  //重定向地址

        //创建一个新curl资源 初始化
        $ch = curl_init();
        //设置URL和对应的选项
        curl_setopt($ch,CURLOPT_URL,$url);

        //为post请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //禁止 cURL 验证对等证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //是否检测服务器的域名与证书上的是否一致

        //抓取URL并传给浏览器
        $data = curl_exec($ch);
        echo $data;

        //查看错误码
        $err_code = curl_errno($ch);
        if ($err_code > 0){
            echo "CURL错误码:".$err_code;
            exit;
        }
        //关闭curl资源，并释放系统内存
        curl_close($ch);

//       $oldPass=openssl_decrypt($newPass,$method,$passwd,0,'');

    }

    //非对称加密
    public function keys(Request $request){
        $pass= $request->input('password');

        //加密
        $k = openssl_pkey_get_private('file://'.storage_path('app/key/private.pem'));
        openssl_private_encrypt($pass,$enc_data,$k);
        $arr = base64_encode($enc_data);
//        print_r($arr);
        $url='http://lumen_1809a.com/save2';  //重定向地址

        //创建一个新curl资源 初始化
        $ch = curl_init();
        //设置URL和对应的选项
        curl_setopt($ch,CURLOPT_URL,$url);

        //为post请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //禁止 cURL 验证对等证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //是否检测服务器的域名与证书上的是否一致

        //抓取URL并传给浏览器
        $data = curl_exec($ch);
        echo $data;

        //查看错误码
        $err_code = curl_errno($ch);
        if ($err_code > 0){
            echo "CURL错误码:".$err_code;
            exit;
        }
        //关闭curl资源，并释放系统内存
        curl_close($ch);

    }

    public function qian(){
        $data = [
            'nicjname'    => '测试商品',
            'amout'       => 200,
            'title'       => '测试订单',
            'create_time' => time(),
        ];

        $arr = json_encode($data);  //发送到数据
        $k = openssl_get_privatekey('file://'.storage_path('app/key/private.pem'));
        //计算签名  使用私钥对数据签名
        openssl_sign($arr,$sign,$k);
        $ba64 = base64_encode($sign);

        $url = 'http://lumen_1809a.com/save3?sign='.urlencode($ba64);

        $ch = curl_init();
        //设置URL和对应的选项
        curl_setopt($ch,CURLOPT_URL,$url);

        //为post请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            'Content-Type:text/plain'
        ]);

        //抓取URL并传给浏览器
        $data = curl_exec($ch);
        echo $data;

        //监控错误码
        $err_code = curl_errno($ch);
        if ($err_code > 0){
            echo "CURL错误码:".$err_code;
            exit;
        }
        //关闭curl资源，并释放系统内存
        curl_close($ch);
    }
}
