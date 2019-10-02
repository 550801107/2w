<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Store;
use App\Admin\Forms\Users;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class AddstoreController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '添加门店';

    public function add(Content $content)
    {
        return $content
            ->title($this->title())
            ->body(new Store());
    }






}
