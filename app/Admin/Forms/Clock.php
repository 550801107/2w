<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use App\Models\HdrsClock;

class Clock extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '签到规则';

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
        $rules = HdrsClock::all()->first();
        if($rules){
            $rules ->rules = $request->rules;
            $rules ->integral = $request->integral;
            $rules ->days = $request->days;
            $rules ->days_integral = $request->days_integral;
            $result = $rules->save();
            if($result){
                admin_success('保存成功');
                return redirect('/admin/hdrsclock');
            }else{
                admin_error('保存失败');
                return back();
            }
        }else{
            $model = new HdrsClock();
            $model ->rules = $request->rules;
            $model ->integral = $request->integral;
            $model ->days = $request->days;
            $model ->days_integral = $request->days_integral;
            $result = $model->save();
            if($result){
                admin_success('保存成功');
                return redirect('/admin/hdrsclock');
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
//        $this->textarea('rules', __('签到规则'));
        $this->number('integral', __('每日签签到获得积分'));
        $this->number('days', __('连续签到天数'));
        $this->number('days_integral', __('连续签到获得积分'));

    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $rules = HdrsClock::all()->first();
        if($rules){
            return [
                'rules'       => $rules->rules,
                'integral'      => $rules->integral,
                'days' => $rules->days,
                'days_integral' => $rules->days_integral,
            ];
        }else{
            return [];
        }
    }
}
