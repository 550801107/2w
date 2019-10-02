<?php

namespace App\Admin\Forms;

use App\Models\AdminUsers;
use App\Models\RileUser;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Store extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '门店';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());
        $flight = new AdminUsers();
        $flight->store_name = $request->store_name;
        $flight->mobile = $request->mobile;
        $flight->address = $request->address;
        $flight->username = $request->username;
        $flight->password = bcrypt($request->password);
        $result = $flight->save();
        if($result){
            $mobile = new RileUser();
            $mobile->role_id = 2;
            $mobile->user_id = $flight->id;
            $res = $mobile->save();
            if($res){
                admin_success('添加成功');
                return redirect('/admin/manage_all_store');
            }else{
                admin_error('添加失败');
                return back();
            }
        }else{
            admin_error('添加失败');
            return back();
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('store_name', __('门店名称'));
        $this->mobile('mobile', __('联系方式'));
        $this->text('address', __('门店地址'));
        $this->text('username', __('管理员账号'));
        $this->password('password', '密码');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [];
    }
}
