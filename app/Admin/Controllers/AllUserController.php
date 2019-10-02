<?php

namespace App\Admin\Controllers;

use App\Models\AdminUsers;
use App\Models\HdrsArea;
use App\Models\HdrsGroup;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AllUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->model()->orderBy('id', 'desc');

        //关闭新增
        $grid->disableCreateButton();
        //关闭某操作
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
//            $actions->disableDelete();
            $actions->disableView();
            $id = $actions->getKey();
            // prepend一个操作
            $actions->prepend("<a href='/admin/share_list/$id'>分享记录</a>　");
            $actions->prepend("<a href='/admin/store_user/$id'>积分明细</a>　");
        });

        $grid->column('id')->sortable();
		$grid->avatar('头像')->image(env('IMG_URL'), 30, 30);
		$grid->column('nickname', __('admin.Nickname'));
		$grid->column('mobile', '手机号');
        $grid->column('area.name', '所属区域');
        $grid->column('adminUsers.store_name', '所属门店');
        $grid->column('group.name', '会员分组');
        $grid->column('integral', '积分');

        $grid->column('is_members', '是否认证')->display(function ($is_member) {
			return $is_member == 2 ? '已认证' : '未认证';
		});
        $grid->column('active', '状态')->display(function ($active) {
		 	return	$active == User::ACTIVE ? '启用' : '禁用';
		});
        $grid->column('updated_at', '更新时间');

        // 筛选条件
		$grid->filter(function ($filter) {
			$filter->column('0.5',function (Grid\Filter $filter) {
				$filter->equal('active', '会员状态')->select([User::ACTIVE => '启用', User::NOT_ACTIVE => '禁用']);
				$filter->like('nickname', '昵称');
				$filter->equal('adminUsers.id', '所属门店')->select(AdminUsers::getIdToStoreName());
				$filter->equal('group.id', '会员分组')->select(HdrsGroup::getIdToName());
				$filter->equal('mobile', '手机号');
			});
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
        $show = new Show(User::findOrFail($id));

        $show->field('nickname', __('admin.Nickname'));
        $show->field('mobile', __('admin.Mobile'));
        $show->field('updated_at', __('admin.Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);
        $form->text('nickname', __('admin.Nickname'));
        $form->mobile('mobile', __('admin.Mobile'));
        $form->image('avatar', __('admin.Avatar'));
        $form->select('area_id', '所属区域')->options(HdrsArea::getIdToName());
        $form->select('group_id', '所属会员分组')->options(HdrsGroup::getIdToName());
        $form->switch('is_members', '是否认证')->states(User::getIsMemberDescript())->default(1);

        $form->switch('active', __('admin.Active'))->states(getStatusDescript())->default(1);
        $form->email('email', __('admin.Email'));

        return $form;
    }
}
