<?php

namespace App\Admin\Middleware;

use Closure;
use Encore\Admin\Facades\Admin;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	// 必须登录
    	if (!empty(Admin::user())){
    		// 当跳转到admin时
    		if ($request->is('admin')){
    			// 如果是Administrator,跳转到admin/all_user
				if (Admin::user()->isRole('manager')){
				 return	redirect('admin/all_user');
				}else{// 其他都跳转的,admin/store_user
				 return	redirect('admin/store_user');
				}

			}
		}
        return $next($request);
    }
}
