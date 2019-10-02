<?php

namespace App\Admin\Controllers;

use App\Models\HdrsComplaints;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ComplaintsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '投诉管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HdrsComplaints);
        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function($filter){

			// 去掉默认的id过滤器
			$filter->disableIdFilter();

			// 在这里添加字段过滤器
			$filter->like('user.name', '姓名');
			$filter->notEqual('user.mobile', '手机号');

		});

        //关闭某操作
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
        });
        $grid->disableCreateButton();

        //关闭导出
        $grid->disableExport();


        $grid->column('id', __('Id'));
        $grid->column('user.avatar', __('头像'))->image(env('IMG_URL'), 30, 30);
        $grid->column('user.nickname', __('昵称'));
        $grid->column('user.mobile', __('手机号'));
        $grid->column('title', __('标题'));
        $grid->column('content', __('内容'));
        $grid->column('created_at', __('投诉时间'));

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
        $show = new Show(HdrsComplaints::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user.name', __('昵称'));
        $show->field('user.mobile', __('手机号'));
        $show->field('title', __('标题'));
        $show->field('content', __('内容'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HdrsComplaints);

        $form->number('user_id', __('User id'));
        $form->text('title', __('Title'));
        $form->text('user.name', __('user.name'));
        $form->textarea('content', __('Content'));

        return $form;
    }
}
