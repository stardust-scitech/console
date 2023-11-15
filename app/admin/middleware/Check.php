<?php
declare (strict_types = 1);

namespace app\admin\middleware;
use think\facade\Db;

class Check
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return 
     */
    public function handle($request, \Closure $next)
    {
        $account = session('adminAccount');

        if($account && $account['id'])
        {
            /* 已登录直接跳转 */
            if(preg_match('/login/i',$request->pathinfo()))
            {
                return redirect((string)url('Index/index'));
            }
        }else
        {
            if($request->pathinfo() != 'Login/index.html')
            {
                return redirect((string)url('Login/index'));
            }
        }

        return $next($request);
    }
}
