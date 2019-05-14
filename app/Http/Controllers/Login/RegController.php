<?php

namespace App\Http\Controllers\Login;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegController extends Controller
{

    public function regindex(){
        return view('login.reg');
    }

    public function reg(Request $request){
        $pass= $request->input('password');
        $email= $request->input('email');
        $nickname= $request->input('nickname');
        $tel= $request->input('tel');


        //验证邮箱
        // $email = UserModel::where(['email'=>$email])->first();
        // if($email){
        //     $response = [
        //         'errno' =>  50003,
        //         'msg'   =>  '邮箱已存在',
        //     ];
        //     die(json_encode($response,JSON_UNESCAPED_UNICODE));
        // }

        $info = [
            'tel'      => $tel,
            'nickname' => $nickname,
            'password' => $pass,
            'email'    => $email,
        ];
        // print_r($info);die;
        

        $post_json = json_encode($info);
        //加密
        $k = openssl_pkey_get_private('file://'.storage_path('app/key/private.pem'));
        openssl_private_encrypt($post_json,$enc_data,$k);
        $arr = base64_encode($enc_data);
        // print_r($arr);
        $url='http://lumen_1809a.com/save4';  //重定向地址

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
}
