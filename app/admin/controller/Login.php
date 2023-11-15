<?php

namespace app\admin\controller;

use think\facade\Db;
use app\BaseController;

class Login extends BaseController
{
    /* 后台登录的逻辑 */
    public function index()
    {
        // $config = require('../config/captcha.php');
        // $Verify = new \think\captcha\Captcha($config);

        if (request()->isPost()) {
            $data = input('post.');

            /* 通过用户名获取用户相关信息 */
            $adminData = Db::name('admin')->where('username', $data['username'])->find(); // 一维数组

            if (!captcha_check($data['verifycode'])) {
                return alert('验证码不正确', './login', 5, 3); // 校验失败
            }

            if (!$adminData || $adminData['status'] != 1) {
                return alert('用户不存在，或者此用户未被审核通过', './login', 5, 3, 0, captcha_src());
            }

            if ($adminData['password'] != password_salt($data['password'])) {
                return alert('密码不正确', './login', 5, 3, 0, captcha_src());
            }

            session('adminAccount', $adminData);

            return alert('登录成功！', './index', 6, 3);
        } else {
            return view();
        }
    }
}