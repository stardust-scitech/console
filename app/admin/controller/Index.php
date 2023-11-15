<?php
namespace app\admin\controller;

use think\facade\View;
use app\BaseController;

class Index extends Base
{
    public function index()
    {
        return view('', [
            'left_menu' => 1,
        ]);

    }

    /* 退出 */
    public function logout()
    {
        session(null); // 清除session

        return redirect('../login');
    }
}