<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>注册</h2>
<hr/>
<form action="apireg" method="post" enctype="multipart/form-data">
    <p>
        企业名称：<input type="text" id="enterprise_name" name="enterprise_name">
    </p>
    <p>
        法人代表：<input type="text" id="corporate_name" name="corporate_name">
    </p>
    <P>
        银行卡号：<input type="text" id="banck_account" name="banck_account">
    </P>
    <p>
        营业执照：<input type="file" id="license" name="license">
    </p>
    <p>
        <input type="submit" value="REG">
    </p>
</form>
</body>
</html>