<?php

namespace App\Admin\Controllers;

use App\Models\HdrsGroup;
use App\Models\HdrsVideo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VideoController extends AdminController
{
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = '视频管理';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid()
	{
		$grid = new Grid(new HdrsVideo);
        $grid->model()->orderBy('id', 'desc');
        // 筛选条件
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->equal('type', '类型')->select([HdrsVideo::ACTIVE => '会员', HdrsVideo::FREE => '分享']);
            $filter->equal('group.id', '会员分组')->select(HdrsGroup::getIdToName());
        });

		$grid->column('id', __('Id'))->sortable();
		$grid->column('title', __('标题'));
        $grid->picture('缩略图')->image(env('IMG_URL'), 30, 30);
		$grid->column('video_url', __('视频地址'));
		$grid->column('get_integral', '可获得积分');
		$grid->column('length_time', '多长时间可获得积分(s)');
		$grid->column('pv', __('浏览量'));
		$grid->column('group.name', '会员分组');
		$grid->column('type', __('类型'))->display(function ($type) {
			return $type == HdrsVideo::FREE ? '分享' : '会员';
		});
		$grid->column('active', '状态')->display(function ($active) {
			return $active == HdrsVideo::ACTIVE ? '启用' : '禁用';
		});
		$grid->column('updated_at', '更新时间');

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
		$show = new Show(HdrsVideo::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('title', __('标题'));
		$show->field('picture', __('缩略图'));
		$show->field('video_url', __('视频地址'));
		$show->field('get_integral', __('可获得积分'));
		$show->field('length_time', __('多长时间可获得积分(s)'));
		$show->field('number', __('浏览量'));
		$show->field('group_id', __('会员分组'));
		$show->field('type', __('类型'));
		$show->field('created_at', __('添加时间'));

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form()
	{
		$form = new Form(new HdrsVideo);

		$form->text('title', __('标题'));
		$form->image('picture', __('缩略图'));
		$form->file('video_url', '上传视频')->options([
		                                              'showPreview' => false,
//													  'showUpload'=>true,
                                                      'uploadAsync' =>true,
                                                      ]);
		$form->text('length_time', __('多长时间可获得积分(s)'));
		$form->select('group_id', '所属会员分组')->options(HdrsGroup::getIdToName());
		$form->number('get_integral', __('可获得积分'))->default(0);
		$form->number('pv', __('浏览量'))->default(0);
		$form->switch('type', __('类型'))->states(getVideoTypeDescript())->default(1);
		$form->switch('active', __('状态'))->states(getStatusDescript())->default(1);
		return $form;
	}
}
