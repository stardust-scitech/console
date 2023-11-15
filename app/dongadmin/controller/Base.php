<?php

namespace app\dongadmin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;
use think\exception\HttpResponseException;


class Base extends  BaseController {
      
  
  public function initialize() {
    
   //后台的所有方法都会先执行这里，再向下执行，所以我们在这里进行权限控制
   //重定向在base中失效，只有在控制其中生效
    $loginAdmin =session('adminAccount');
    $this->auth($loginAdmin);//权限控制
    $this->leftmenu($loginAdmin);//左侧菜单

    
    
  }

 
    //权限控制
    public function auth($loginAdmin){
      $request=Request::instance();
      
      
      $module='dongadmin';
      $con=$request->controller();
      $action=$request->action();
      
      $name=$module.'/'.$con.'/'.$action;//组合规则name
      
      
      $auth_rule_str=Db::name('auth_group')->where('id',$loginAdmin['group_id'])->value('rules');

      
      
      if(!empty($auth_rule_str)){
        $auth_rule_arr=explode(',',$auth_rule_str);
        
        foreach($auth_rule_arr as $k=>$v){
          $res=Db::name('auth_rule')->find($v);
          if($res['name']==$name && $res['status']==1){
            return true;
          }
        }
      }
      //没有权限就跳转到后台首页
      return $this->redirect('/dongadmin/index/index');
    }

    public function redirect(...$args){
      throw new HttpResponseException(redirect(...$args));
    }



    //后台左侧菜单数据
    public function leftmenu($loginAdmin){

      $menuData1=$menuData2=$menuData3=[];
      $auth_rule_str=Db::name('auth_group')->where('id',$loginAdmin['group_id'])->where('status',1)->value('rules');
      
      $menu=Db::name('auth_rule')->where('parent_id',0)->where('id','in',$auth_rule_str)->where('status',1)->select()->toArray();
      //halt($menu);
     
      foreach($menu as $k=>$v){
        if($v['type']==1){
          $menuData1[]=$v;
        }
        if($v['type']==2){
          $menuData2[]=$v;
        }
        if($v['type']==3){
          $menuData3[]=$v;
        }
      }
      View::assign('menuData1',$menuData1);
      View::assign('menuData2',$menuData2);
      View::assign('menuData3',$menuData3);
      
      
      
    }
    
    


}