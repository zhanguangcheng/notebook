<?php

/* QQ的oAuth测试 */
{
    // 文件一:
    /* 第一步: 跳转至QQ登录页面 */
    $client_id = '';
    $client_secret = '';
    $redirect_uri = 'http://localhost/test/callback.php';

    $state = md5(uniqid(rand(), true));// 验证用(自定义)
    $params = array(
        "response_type" => "code",
        "client_id" => $client_id,
        "redirect_uri" => urlencode($redirect_uri),
        "state" => $state,
        "scope" => 'all'
    );
    $url = 'https://graph.qq.com/oauth2.0/authorize?' . http_build_query($params);

    // 跳转至QQ登录页面
    header('location:' . $url);

    // 文件二:
    /* 第二步: QQ回调并带回code */
    /*
    var_dump($_GET);
    array(2) {
      ["code"]=>
      string(32) "F9DD0C8313E33035A2BAA5AEE1E22FBE"
      ["state"]=>
      string(32) "9e93fcd7c676423117496a92f264393f"
    }
     */

    /* 第三步: 通过code获取access_token */
    // 获取access_token
    $params = array(
        "grant_type" => "authorization_code",
        "client_id" => $client_id,
        "redirect_uri" => $redirect_uri,
        "client_secret" => $client_secret,
        "code" => $_GET['code']
    );
    $url = 'https://graph.qq.com/oauth2.0/token?' . http_build_query($params);
    $response = get($url);
    // var_dump($response);
    // 成功: access_token=4EDA3A4A8DC9A87E3D3AF55F12BC497C&expires_in=7776000&refresh_token=A4FDB6B23AF860A2AE6354245A56C4CC
    // 失败: callback( {"error":100019,"error_description":"code to access token error"} ); 

    parse_str($response, $args);
    /*
    var_dump($args);
    array(3) {
      ["access_token"]=>
      string(32) "4EDA3A4A8DC9A87E3D3AF55F12BC497C"
      ["expires_in"]=>
      string(7) "7776000"
      ["refresh_token"]=>
      string(32) "A4FDB6B23AF860A2AE6354245A56C4CC"
    }
     */

    /* 第四步: 通过access_token获取openid */
    // 获取 openid
    $params = array(
        "access_token" => $args['access_token']
    );
    $url = 'https://graph.qq.com/oauth2.0/me?' . http_build_query($params);
    $response = get($url);
    var_dump($response);
    // 成功: callback( {"client_id":"101383043","openid":"70F41502D836B0DA9D7F8CBFA4F00AA1"} ); 
    // 失败: callback( {"error":100007,"error_description":"param access token is wrong or lost "} ); 

    /* 第五步: 通过appid(client_id) access_token openid 获取其它数据 */
    // 获取用户基础数据
    $params = array(
        'appid' => $client_id,
        "access_token" => $args['access_token'],
        "openid" => '70F41502D836B0DA9D7F8CBFA4F00AA1',
    );
    $url = 'https://graph.qq.com/user/get_user_info?' . http_build_query($params);
    $response = get($url);
    var_dump($response);
    // 失败: {"ret":-1,"msg":"client request's parameters are invalid"}
    /*
    成功: 
    {
        "ret": 0,
        "msg": "",
        "is_lost":0,
        "nickname": "心丞小草",
        "gender": "男",
        "province": "上海",
        "city": "闵行",
        "year": "1990",
        "figureurl": "http:\/\/qzapp.qlogo.cn\/qzapp\/101383043\/70F41502D836B0DA9D7F8CBFA4F00AA1\/30",
        "figureurl_1": "http:\/\/qzapp.qlogo.cn\/qzapp\/101383043\/70F41502D836B0DA9D7F8CBFA4F00AA1\/50",
        "figureurl_2": "http:\/\/qzapp.qlogo.cn\/qzapp\/101383043\/70F41502D836B0DA9D7F8CBFA4F00AA1\/100",
        "figureurl_qq_1": "http:\/\/q.qlogo.cn\/qqapp\/101383043\/70F41502D836B0DA9D7F8CBFA4F00AA1\/40",
        "figureurl_qq_2": "http:\/\/q.qlogo.cn\/qqapp\/101383043\/70F41502D836B0DA9D7F8CBFA4F00AA1\/100",
        "is_yellow_vip": "0",
        "vip": "0",
        "yellow_vip_level": "0",
        "level": "0",
        "is_yellow_year_vip": "0"
    }
    */
    function get($url)
    {
       $ch = curl_init();
       $opts = array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_SSL_VERIFYPEER => false,
       );
       curl_setopt_array($ch, $opts);
       $response = curl_exec($ch);
       if (curl_error($ch)) {
           echo curl_error($ch);
           curl_close($ch);
           die;
       }
       curl_close($ch);
       return $response;
    }
}

/* github的oAuth测试 */
{
    $client_id = '';
    $client_secret = '';
    $redirect_uri = 'http://localhost/test/callback.php';
    // 文件一:
    /* 第一步: 跳转至github登录页面 */
    $params = [
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'scope' => 'user',
        'state' => 1,
    ];
    $url = 'https://github.com/login/oauth/authorize?' . http_build_query($params);

    // 跳转至github登录页面
    header('location:' . $url);

    // 文件二:
    /* 第二步: github回调并带回code */
    /*
    var_dump($_GET);
    array(2) {
      ["code"]=>
      string(20) "17e95276f7718bef818a"
      ["state"]=>
      string(1) "1"
    }
     */

    /* 第三步: 通过code获取access_token */
    $url = 'https://github.com/login/oauth/access_token';
    $params = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        'redirect_uri' => $redirect_uri,
        'state' => 1,
    ];
    $response = post($url, http_build_query($params));
    // 成功: access_token=e2991aa42f76fae04dec1728553cc71657b55bb8&scope=user&token_type=bearer
    // 失败: error=bad_verification_code&error_description=The+code+passed+is+incorrect+or+expired.&error_uri=https%3A%2F%2Fdeveloper.github.com%2Fv3%2Foauth%2F%23bad-verification-code
    parse_str($response, $args);
    /*
    var_dump($args);
    array(3) {
      ["access_token"]=>
      string(40) "e2991aa42f76fae04dec1728553cc71657b55bb8"
      ["scope"]=>
      string(4) "user"
      ["token_type"]=>
      string(6) "bearer"
    }
    */

   /* 第四步: 通过access_token获取其它数据 */
   // 获取用户基础数据
   $access_token = $args['access_token'];
   $url = 'https://api.github.com/user?access_token=' . $access_token;
   $response = get($url);
   var_dump($response);
   // 失败: {"message":"Bad credentials","documentation_url":"https://developer.github.com/v3"}
   // 成功: {"login":"121616591","id":15117930,"avatar_url":"https://avatars3.githubusercontent.com/u/15117930?v=3","gravatar_id":"","url":"https://api.github.com/users/121616591","html_url":"https://github.com/121616591","followers_url":"https://api.github.com/users/121616591/followers","following_url":"https://api.github.com/users/121616591/following{/other_user}","gists_url":"https://api.github.com/users/121616591/gists{/gist_id}","starred_url":"https://api.github.com/users/121616591/starred{/owner}{/repo}","subscriptions_url":"https://api.github.com/users/121616591/subscriptions","organizations_url":"https://api.github.com/users/121616591/orgs","repos_url":"https://api.github.com/users/121616591/repos","events_url":"https://api.github.com/users/121616591/events{/privacy}","received_events_url":"https://api.github.com/users/121616591/received_events","type":"User","site_admin":false,"name":"grass","company":null,"blog":null,"location":null,"email":"121616591@qq.com","hireable":null,"bio":"DDS","public_repos":1,"public_gists":1,"followers":1,"following":3,"created_at":"2015-10-14T03:45:26Z","updated_at":"2017-03-06T13:01:40Z","private_gists":0,"total_private_repos":0,"owned_private_repos":0,"disk_usage":0,"collaborators":0,"two_factor_authentication":false,"plan":{"name":"free","space":976562499,"collaborators":0,"private_repos":0}
   function get($url)
   {
       $ch = curl_init();
       $opts = array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_SSL_VERIFYPEER => false,
           CURLOPT_HTTPHEADER => array(
               'User-Agent: Awesome-Octocat-App'// github必须
           ),
       );
       curl_setopt_array($ch, $opts);
       $response = curl_exec($ch);
       if (curl_error($ch)) {
           echo curl_error($ch);
           curl_close($ch);
           die;
       }
       curl_close($ch);
       return $response;
   }

   function post($url, $data)
   {
       $ch = curl_init();
       $opts = array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_SSL_VERIFYPEER => false,
           CURLOPT_POST => true,
           CURLOPT_POSTFIELDS => $data
       );
       curl_setopt_array($ch, $opts);
       $response = curl_exec($ch);
       if (curl_error($ch)) {
           echo curl_error($ch);
           curl_close($ch);
           die;
       }
       curl_close($ch);
       return $response;
   }
}
