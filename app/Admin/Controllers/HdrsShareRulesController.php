<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ShareRules;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class HdrsShareRulesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分享设置';

    public function rules(Content $content)
    {
        return $content
            ->title($this->title())
            ->body(new ShareRules());
    }

}
