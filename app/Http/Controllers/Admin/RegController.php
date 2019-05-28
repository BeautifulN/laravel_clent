<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RegController extends Controller
{
    public function license()  //审核展示
    {
        $id = Auth::id();
        $arr = DB::table('company')->where('company_id',$id)->first();

        $res = DB::table('users')->where('id',$id)->first();
        return view('admin.admin',['arr'=>$arr,'res'=>$res]);
    }

    public function license_do(Request $request)  //审核通过
    {
        $company_id = $request->input('company_id');
        $info = [
            'company_status'=>2
        ];

        $arr = DB::table('company')->where('company_id',$company_id)->update($info);
        // var_dump($arr);
        if($arr){
            $appid =date("YmdHis",time()).rand(1000,9999);
            $key = substr(rand(999,10000).Str::random(20),2,25);

            $data_key = [
                'appid'   => $appid,
                'key'     => $key,
            ];

            $data = DB::table('company')->where('company_id',$company_id)->update($data_key);

            $arr = ['status'=>0,'msg'=>'审核成功'];
            $arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
            return $arr;
        }else{
            $arr = ['status'=>1,'msg'=>'审核失败'];
            $arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
            return $arr;
        }
    }

    public function token()  //获取token
    {
        $company_id = $_GET['company_id'];
        $data = DB::table('company')->where('company_id',$company_id)->first();

        $appid = $data->appid;
        $key = $data->key;

        $api_info = [
            'appid'   => $appid,
            'key'     => $key,
            'company_id'     => $company_id,
        ];

        $url='http://clent.1809a.com/accessToken';

        //创建一个新curl资源 初始化
        $ch = curl_init();
        //设置URL和对应的选项
        curl_setopt($ch,CURLOPT_URL,$url);

        //为post请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$api_info);

        //禁止浏览器输出，用变量接收
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //禁止 cURL 验证对等证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //抓取URL并传给浏览器
        $data = curl_exec($ch);
        echo 'token=' . $data;
        $arr = DB::table('company')->where('company_id',$company_id)->update(['access_token'=>$data]);
        if ($arr){
            $response = [
                'status' => 0,
                'msg'   => 'ok',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }

    public function apireg_list()  //注册展示
    {

        return view('admin.reg');
    }

    public function apireg(Request $request)  //审核展示
    {
        $enterprise_name = $request->input('enterprise_name');
        $corporate_name = $request->input('corporate_name');
        $banck_account = $request->input('banck_account');
        $license = $this->upload($request,'license');

        if (empty($enterprise_name)){
            echo ('企业名称必填');die;
        }elseif (empty($corporate_name)){
            echo ('法人代表必填');die;
        }elseif (empty($banck_account)){
            echo ('银行卡号必填');die;
        }


//        $token_key = 'zzztoken:id' .$arr->id;
//        Redis::set($token_key,$token);
//        Redis::expire($token_key,604801);

        $data = [
            'enterprise_name'      => $enterprise_name,
            'corporate_name'       => $corporate_name,
            'banck_account'        => $banck_account,
            'license'              => $license,
            'id'                   => Auth::id(),
        ];

        $arr1 = DB::table('company')->insertGetId($data);
        if ($arr1){
            echo '账号申请成功';
        }

    }

    public function upload(Request $request,$filename)  //文件上传
    {
        if ($request->hasFile($filename) && $request->file($filename)->isValid()) {
            $photo = $request->file($filename);
            // $extension = $photo->extension();
            // $store_result = $photo->store('photo');
            $store_result = $photo->store('uploads/'.date('Ymd'));
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }

    public function accessToken()  //token生成
    {
        $token=substr(Str::random(15).time(),2,15);
        $company_id = $_POST['company_id'];
        $key = 'token:ip:' . $_SERVER['REMOTE_ADDR'] . 'company_id:' . $company_id;
        $res = Redis::incr($key);
        Redis::expire($key,60);
        return $token;

    }

    public function ip()  //获取ip
    {
        $id = Auth::id();
        $arr = DB::table('company')->where('company_id',$id)->first();
        if ($arr->company_status == 1){
            $arr = ['status'=>0,'msg'=>'未审核 请拨打:16638339427(女的)   申请审核'];
            return $arr;
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
            $arr = ['status'=>1,'msg'=>'ip:'.$ip];
            return $arr;

        }

    }

}
