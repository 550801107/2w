<?php

namespace App\Admin\Forms;

use App\Admin\Controllers\BaseController;
use App\Models\AdminUsers;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use App\Models\HdrsArea;
use App\Models\HdrsGroup;
use App\User;
use Encore\Admin\Facades\Admin;

class Users extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '会员认证';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $id = Admin::user()->id;
//        dump($request->mobile);
        $flight = User::where('mobile',"=",$request->mobile)->first();
        if(!empty($flight)){
            $flight = $flight->toArray();
            $model = User::find($flight['id']);
            $model->nickname = $request->nickname;
            $model->area_id = $request->area_id;
            $model->group_id = $request->group_id;
            $model->admin_users_id =$id;
            $model->is_members = 2;
            $res = $model->save();
            if($res){
                $model = AdminUsers::find($id);
                $model ->storenumber = $model['storenumber']+1;
                $model ->save();
                admin_success('认证成功');
                return redirect('/admin/store_user/');
            }else{
                admin_error('认证失败');
                return back();
            }
        }else{
            $model = new User();
            $model->mobile = $request->mobile;
            $model->nickname = $request->nickname;
            $model->area_id = $request->area_id;
            $model->group_id = $request->group_id;
            $model->admin_users_id =$id;
            $model->is_members = 2;
            $res = $model->save();
            if($res){
                $model = AdminUsers::find($id);
                $model ->storenumber = $model['storenumber']+1;
                $model ->save();
                admin_success('认证成功');
                return redirect('/admin/store_user/');
            }else{
                admin_error('认证失败');
                return back();
            }
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('nickname', __('姓名'));
        $this->mobile('mobile', __('手机号'));
        $this->select('area_id', '所属区域')->options(HdrsArea::getIdToName());
        $this->select('group_id', '所属会员分组')->options(HdrsGroup::getIdToName());
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
