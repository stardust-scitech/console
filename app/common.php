<?php
// 应用公共文件



/**

 * $msg 待提示的消息

 * $url 待跳转的链接

 * $icon 这里主要有两个，5和6，代表两种表情（哭和笑）

 * $time 弹出维持时间（单位秒）

 */


function alert($msg='',$url='',$icon='',$time=3){ 

    $str='<script type="text/javascript" src="/public/static/index/js/jquery-3.4.1.min.js"></script><script type="text/javascript" src="/public/static/admin2/layer/2.4/layer.js"></script>';//加载jquery和layer

    $str.='<script>$(function(){layer.msg("'.$msg.'",{icon:'.$icon.',time:'.($time*1000).'});setTimeout(function(){self.location.href="'.$url.'"},2000)});</script>';//主要方法

    return $str;

}


//通用后台密码加盐
function password_salt($str){
    $salt='ddsEf6KJ';
    return md5($str.$salt);
}