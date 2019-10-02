<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use App\Models\HdrsIntegralLog;
use App\User;

class Integral extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '积分消耗';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
//        dump($request->all());
        $model = User::find($request->id);
        $integral = $model->integral - abs($request->integral_num);
        if($integral<0){
            admin_error('积分不足');
            return back();
        }else{
            $flight = User::find($request->id);
            $flight->integral = $integral;
            $res = $flight->save();
            if($res){
                $flight = new HdrsIntegralLog;
                $flight->user_id = $request->id;
                $flight->goods = $request->goods;
                $flight->integral_num = '-'.abs($request->integral_num);
                $flight->title = $request->title;
                $result = $flight->save();
                if($result){
                    admin_success('保存成功');
                    return redirect('/admin/store_user/');
                }else{
                    admin_error('保存失败');
                    return back();
                }
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
        $this->text('goods', __('商品名称'));
        $this->text('integral_num', __('扣除积分'));
        $this->hidden('id');
        $this->textarea('title', '备注');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'id'       => \request('id'),
        ];
    }
}
