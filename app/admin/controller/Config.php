<?php
namespace app\admin\controller;

class Config extends Base
{
    public function index()
    {
        return view('', [
            'left_menu' => 3
        ]);
    }
}