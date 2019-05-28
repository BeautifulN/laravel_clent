<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsallController extends Controller
{
    public function goodsall()  //商品展示列表
    {
        $arr = DB::table('goods')->get();
        return[
            'status'=>0,
            'data'=>$arr,
        ];
    }

    public function content(Request $request)  //商品详情
    {
//        $goods_id = $request->input('goods_id');
        $goods_id = $_GET['goods_id'];
        $arr = DB::table('goods')->where(['goods_id'=>$goods_id])->first();

        $info = [
            'goods_id'             => $goods_id,
            'goods_name'           => $arr->goods_name,
            'goods_num'            => $arr->goods_num,
            'goods_selfprice'      => $arr->goods_selfprice,
        ];

        $info_json = json_encode($info);
//        print_r($info_json);

        $url='http://lumen_1809a.com/content';  //重定向地址

        //创建一个新curl资源 初始化
        $ch = curl_init();
        //设置URL和对应的选项
        curl_setopt($ch,CURLOPT_URL,$url);

        //为post请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$info_json);

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


    public function cart(Request $request)  //添加购物车
    {
        $goods_id = $_GET['goods_id'];
        $user_id = $_GET['id'];
        $buy_number = $request->input('buy_number');

        $info = [
            'goods_id'             => $goods_id,
            'user_id'              => $user_id,
            'buy_number'           => $buy_number,
        ];
        $cart_json = json_encode($info);

//        print_r($cart_json);

        $url='http://lumen_1809a.com/cart';  //重定向地址

        //创建一个新curl资源 初始化
        $ch = curl_init();
        //设置URL和对应的选项
        curl_setopt($ch,CURLOPT_URL,$url);

        //为post请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$cart_json);

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


    public function cartlist()  //购物车展示
    {
        $arr = DB::table('cart')->get();
        return[
            'status'=>0,
            'data'=>$arr,
        ];
    }


    public function order()  //订单生成
    {
        $goods_id = $_GET['goods_id'];
        $user_id = $_GET['id'];

        $info = [
            'goods_id'             => $goods_id,
            'user_id'              => $user_id,
        ];

        $order_json = json_encode($info);

//        print_r($order_json);

        $url='http://lumen_1809a.com/order';  //重定向地址

        //创建一个新curl资源 初始化
        $ch = curl_init();
        //设置URL和对应的选项
        curl_setopt($ch,CURLOPT_URL,$url);

        //为post请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$order_json);

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


    public function order_detail()  //订单展示
    {
        $arr = DB::table('order')->join('order_detail','order.order_id','=','order_detail.order_id')->get();
//        $arr = DB::table('order')->get();
//        print_r($arr);
        return[
            'status'=>0,
            'data'=>$arr,
        ];
    }

}
