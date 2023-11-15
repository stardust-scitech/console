<?php
declare (strict_types = 1);

namespace app\dongadmin\middleware;
use think\facade\Db;
class Check
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //判断当前有没有登录session session('adminAccount');
        //判断当前是不是登录页面 多次重定向的问题
        
        // 后置中间件  在没有登录的状态下，后台就已经执行了代码，执行后再去跳转到登录
        //halt($request);
        if(empty(session('adminAccount')) && !preg_match('/login/',$request->pathinfo())){
            //echo'<br>后置中间件<br>';
            return redirect((string)url('login/index'));
        }
       
    
        return $next($request);
    }
}
