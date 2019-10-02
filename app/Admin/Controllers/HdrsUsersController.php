<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\HdrsGroup;
use Encore\Admin\Facades\Admin;
use App\Models\HdrsIntegralLog;
use App\Models\HdrsArea;

class HdrsUsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $id = Admin::user()->id;
        $grid->model()->where([['admin_users_id',$id]])->orderBy('id', 'desc');

        // 筛选条件
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->equal('group.id', '会员分组')->select(HdrsGroup::getIdToName());
            $filter->like('nickname', '姓名');
            $filter->like('mobile', '手机号');
        });

        //关闭新增
        $grid->disableCreateButton();

        //关闭某操作
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableDelete();
            $actions->disableView();
            $id = $actions->getKey();
            // prepend一个操作
            $actions->prepend("<a href='/admin/store_user/$id'>积分明细</a>");
            $actions->prepend("<a href='/admin/integral_xh/$id'>积分消耗</a>　");
        });


        //添加头部
        $grid->header(function ($query) {
            $jin = User::getTody();
            $zuo = User::getYesterday();
            return "　　　　　今日会员绑定数量$jin"."　　　　　　　　　　　"."昨日会员绑定数量$zuo"."　　　　　　　　　　<a  class='btn btn-sm btn-default  pull-right' style='background-color: #1087dd' href='/admin/certification'><i class='fa fa-edit'>会员认证</i></a>";
        });
        $grid->column('id', __('Id'));
        $grid->column('nickname', __('姓名'));
        $grid->column('mobile', __('手机号'));
        $grid->column('group.name', __('会员分组'));
        $grid->column('area.name', '所属区域');
        $grid->column('is_members', '是否认证')->display(function ($is_member) {
            return $is_member == 2 ? '已认证' : '未认证';
        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('integral', __('积分'));
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $mobel = User::findOrFail($id);
        $grid = new Grid(new HdrsIntegralLog);
        $grid->model()->where([['user_id',$mobel['id']]]);

        //添加头部
        $grid->header(function ($query)use ($mobel) {
            return "　　　　　手机号$mobel[mobile]"."　　　　　　　　　　　"."姓名$mobel[nickname]"."　　　　　　　　　　　"."当前积分$mobel[integral]";
        });

        $grid->column('goods', __('商品'));
        $grid->column('title', __('备注'));
        $grid->column('integral_num', __('积分流水'));
        $grid->column('created_at', __('变更时间'));

        //关闭操作
        $grid->disableActions();

        //关闭新增
        $grid->disableCreateButton();

        //关闭搜索
        $grid->disableFilter();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('nickname', __('姓名'));
        $form->mobile('mobile', __('手机号'));
        $form->select('area_id', '所属区域')->options(HdrsArea::getIdToName());
        $form->select('group_id', '所属会员分组')->options(HdrsGroup::getIdToName());

        return $form;
    }
}
