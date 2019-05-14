<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <meta http-equiv="Access-Control-Allow-Origin" content="*"> -->
    <title>SSL</title>
</head>
<body>
    <!-- <form action="keys" method="post">
        {{--<p>--}}
            {{--<input type="text" >--}}
        {{--</p>--}}
        <p>
            <input type="password" id="password" name="password">
        </p>
        <p>
            <input type="submit" value="PLAY">
        </p>
    </form> -->

    <p>
        <input type="button" value="CESHI" id="btnLogin">
    </p>
</body>
</html>

<script src="js/jquery/jquery-1.12.4.min.js"></script>
<script>
    $(function(){
        $('#btnLogin').click(function(){
            var data = {};
            var user_tel=123456789;
            data.user_tel = user_tel;
            var url = "http://lumen_1809a.com/aaa";
            $.ajax({
                type : "get",
                data : data,
                url : url,
                dataType : "jsonp",
                jsonp: "jsonpCallback",
                success:function(msg){
                    alert(msg);
                }
            })
        }); 
    })
</script>