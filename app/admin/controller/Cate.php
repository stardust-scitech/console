<?php
namespace app\admin\controller;

class Cate extends Base
{
    public function index()
    {
        return view('', [
            'left_menu' => 1
        ]);
    }
}