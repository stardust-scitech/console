<?php
namespace app\admin\controller;

use think\facade\View;
use app\BaseController;
use think\facade\Cookie;

class Blog extends Base
{
    public function index()
    {
        // halt('wordpress_logged_in_' . md5('http://localhost/web/blog'));
        // $status = empty( $_COOKIE[ 'wordpress_logged_in_' . md5('http://localhost/web/blog') ] );

        // if($status)  $status = $_COOKIE[ 'wordpress_logged_in_' . md5('http://localhost/web/blog')];

        return view('', [
            'log' => '',
            'cookie' => 'wp-settings-1',
            'pwd' => '',
            'wp-submit' => 'Log In',
            'redirect_to' => 'http://localhost/web/blog/wp-admin/'
        ]);
    }
}