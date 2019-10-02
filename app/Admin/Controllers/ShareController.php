<?php

namespace App\Admin\Controllers;

use App\Models\HdrsShare;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShareController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\HdrsShare';

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $grid = new Grid(new HdrsShare);

        //关闭新增
        $grid->disableCreateButton();
        $grid->model()->where([['send_id',$id]])->orderBy('id', 'desc');

        // 筛选条件
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('share.nickname', '昵称');
        });

        //关闭某操作
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete();
        });
        $grid->disableActions();

        $grid->column('id', __('Id'));
        $grid->column('share.nickname', __('昵称'));
        $grid->column('type', '类型')->display(function ($type) {
            if($type==1){
                $aa = '会员视频';
            }else if($type==2){
                $aa = '分享视频';
            }else{
                $aa = '分享小程序';
            }
            return $aa;
        });
        $grid->column('integral', __('积分'));
        $grid->column('created_at', __('分享时间'));

        return $grid;
    }

}
