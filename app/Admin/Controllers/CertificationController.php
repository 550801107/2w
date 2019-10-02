<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Users;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class CertificationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    public function certification(Content $content)
    {
        return $content
            ->title($this->title())
            ->body(new Users());
    }






}
