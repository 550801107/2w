<?php

namespace App\Admin\Controllers;

use App\Models\AdminUsers;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdminUsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '门店总管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminUsers);
        $grid->model()->orderBy('id', 'desc');
        //添加头部
        $grid->header(function ($query) {
            return "<a  class='btn btn-sm btn-default  pull-right' style='background-color: #1087dd' href='/admin/addstore'><i class='fa fa-plus'>添加门店</i></a>";
        });

        //关闭新增
        $grid->disableCreateButton();

        $grid->column('id', __('序号'));
        $grid->column('username', __('门店账号'));
        $grid->column('store_name', __('门店名称'));
        $grid->column('mobile', __('联系电话'));
        $grid->column('address', __('门店地址'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('storenumber', __('门店人数'));


        // 筛选条件
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('store_name', '门店名称');
            $filter->like('mobile', '联系电话');
        });
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
        $show = new Show(AdminUsers::findOrFail($id));

        $show->field('id', __('序号'));
        $show->field('username', __('门店账号'));
        $show->field('store_name', __('门店名称'));
        $show->field('mobile', __('联系方式'));
        $show->field('address', __('门店地址'));
        $show->field('storenumber', __('门店人数'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdminUsers);

        $form->text('store_name', __('门店名称'));
        $form->mobile('mobile', __('联系方式'));
        $form->text('address', __('门店地址'));
        $form->text('username', __('管理员账号'));
        $form->password('password', trans('admin.password'))->rules('required|confirmed');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });
        $form->ignore(['password_confirmation']);
        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });
        return $form;
    }
}
