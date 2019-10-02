<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Clock;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class HdrsClockController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '签到管理';

    public function rules(Content $content)
    {
        return $content
            ->title($this->title())
            ->body(new Clock());
    }



}
