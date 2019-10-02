<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
// 覆盖`admin`命名空间下的视图
app('view')->prependNamespace('admin', resource_path('views/admin'));
Encore\Admin\Form::forget(['map', 'editor']);

\Encore\Admin\Grid::init(function (\Encore\Admin\Grid $grid) {
// 禁用 行 右边的 按钮
//	$grid->disableActions();
// 禁用分页
//	$grid->disablePagination();
// 禁用创建按钮
//	$grid->disableCreateButton();

//	$grid->disableFilter();

	$grid->disableRowSelector();

	$grid->disableColumnSelector();

//	$grid->disableTools();

	$grid->disableExport();

	$grid->actions(function (\Encore\Admin\Grid\Displayers\Actions $actions) {
		$actions->disableView();
//		$actions->disableEdit();
//		$actions->disableDelete();
	});

});

\Encore\Admin\Form::init(function (\Encore\Admin\Form $form) {

	// 去掉`查看`checkbox
	$form->disableViewCheck();

	// 去掉`继续编辑`checkbox
	$form->disableEditingCheck();

	// 去掉`继续创建`checkbox
	$form->disableCreatingCheck();

	$form->tools(function (\Encore\Admin\Form\Tools $tools) {
		$tools->disableDelete();
		$tools->disableView();
//		$tools->disableList();
	});
});