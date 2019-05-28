<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>审核管理</h2>
<hr/>
<h3>欢迎{{$res->name}}登录</h3>
<table border=1>
    <tr>
        <td>ID</td>
        <td>企业名称</td>
        <td>法人代表</td>
        <td>银行卡号</td>
        <td>营业执照</td>
        <td>审核</td>
        <td>操作</td>
    </tr>
        <tr company_id={{ $arr->company_id }}>
            <td>{{ $arr->company_id }}</td>
            <td>{{ $arr->enterprise_name }}</td>
            <td>{{ $arr->corporate_name }}</td>
            <td>{{ $arr->banck_account }}</td>
            <td><img src="http://clent.1809a.com/{{$arr->license}}" width="50" height="50"></td>
            <td>
                @if ($arr->company_status == 1)
                    未审核
                @else
                    已审核
                @endif
            </td>
            <td>
                {{--[<a href="javascript:;" class="update">修改</a>]--}}
                [<a href="token?company_id={{ $arr->company_id }}">获取token</a>]
                [<a href="javascript:;" class="ipp">获取ip</a>]
            </td>

        </tr>
</table>

</body>
</html>
<script src="js/jquery/jquery-1.12.4.min.js"></script>
<script src="layui/layui.js"></script>
<script>
    $(function () {
    layui.use(['form','layer'],function() {
        var form = layui.form();
        var layer=layui.layer;
            $('.update').click(function () {
                var _this = $(this);
                var data = {};
                var url = "license_do";
                var company_id = _this.parents('tr').attr('company_id');
                data.company_id = company_id;
                $.ajax({
                    type: "POST",
                    data: data,
                    url: url,
                    success: function (msg) {
                        if(msg.status==0){
                            layer.msg(msg.msg);
                            window.location.reload();
                        }else {
                            layer.msg(msg.msg);
                            window.location.reload();
                        }
                    }
                })
            })
            $('.ipp').click(function () {
                var _this = $(this);
                var data = {};
                var url = "ip";
                var company_id = _this.parents('tr').attr('company_id');
                data.company_id = company_id;
                $.ajax({
                    type: "POST",
                    data: data,
                    url: url,
                    success:function(msg) {
//                            alert(msg.msg);
                        if(msg.status==1){
                            layer.msg(msg.msg);
//                            location.href='my.html';
                        }else{
                            layer.msg(msg.msg);
                            // location.href='login.html';
                        }
                    }
                })
            })
        })
    })
</script>
