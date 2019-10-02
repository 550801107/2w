<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use App\Models\HdrsShareRules;

class ShareRules extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '分享设置';

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
        $rules = HdrsShareRules::all()->first();
        if($rules){
            $rules ->integral = $request->integral;
            $result = $rules->save();
            if($result){
                admin_success('保存成功');
                return redirect('/admin/share_rules');
            }else{
                admin_error('保存失败');
                return back();
            }
        }else{
            $model = new HdrsShareRules();
            $model ->integral = $request->integral;
            $result = $model->save();
            if($result){
                admin_success('保存成功');
                return redirect('/admin/share_rules');
            }else{
                admin_error('保存失败');
                return back();
            }
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->number('integral', __('分享所获积分'));
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $rules = HdrsShareRules::all()->first();
        if($rules){
            return [
                'integral'       => $rules->integral,
            ];
        }else{
            return [];
        }
    }
}
