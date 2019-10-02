<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Integral;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class IntegralXhController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '积分消耗';

    public function add(Content $content)
    {
        return $content
            ->title($this->title())
            ->body(new Integral());
    }






}
