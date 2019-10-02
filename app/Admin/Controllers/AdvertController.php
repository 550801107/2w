<?php

namespace App\Admin\Controllers;

use App\Models\HdrsAdvert;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class AdvertController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '广告列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HdrsAdvert);
        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->url('图片')->image(env('IMG_URL'), 30, 30);
        $grid->column('created_at', __('发布时间'));
        $grid->column('status', '状态')->display(function ($active) {
            return $active == HdrsAdvert::ACTIVE ? '启用' : '禁用';
        });
        $grid->column('sort', __('排序'));
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
        $show = new Show(HdrsAdvert::findOrFail($id));

        $show->field('title', __('标题'));
        $show->field('url', __('图片'));
        $show->field('link_url', __('内部链接'));
        $show->field('sort', __('排序'));
        $show->field('status', __('状态'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HdrsAdvert);

        $form->text('title', __('标题'));
        $form->image('url', __('选择图片'));
        $form->text('link_url', __('内部链接'));
        $form->number('sort', __('排序'));
        $form->switch('status', __('是否禁用'));

        return $form;
    }
}
