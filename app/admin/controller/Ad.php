<?php
namespace app\admin\controller;

class Ad extends Base
{
    public function index()
    {
        return view('', [
            'left_menu' => 2
        ]);
    }
}