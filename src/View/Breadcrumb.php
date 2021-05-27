<?php

namespace Sina\Shuttle\View;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $breads;

    public $title;

    public $view;

    public function __construct($data, $page, $view = 'shuttle::breadcrumb')
    {
        $this->view = $view;
        $this->title = $page->title;
        $b = [
            [
                'title' => __('common.home'),
                'url' => '/'
            ],
            [
                'title' => $page->title,
                'url' => $page->url
            ]
        ];
        $this->breads = $b;
    }

    public function render()
    {
        return view($this->view);
//        return $this->html;
    }
}
