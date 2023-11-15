<?php
namespace app\admin\controller;
class Article extends  Base
{
    public function index(){
        return view('',[
         'left_menu'=>1
        ]);
    }

    public function add(){
        return view('',[
         'left_menu'=>1
        ]);
    }

    public function edit(){
        return view('',[
         'left_menu'=>1
        ]);
    }

    public function delete(){
        echo '<h1>删除文章</h1>';
    }
}