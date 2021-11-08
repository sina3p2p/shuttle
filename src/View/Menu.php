<?php

namespace Sina\Shuttle\View;

use Illuminate\View\Component;

class Menu extends Component
{
    public $html;

    public function __construct($id = 0, $ul="", $li="", $a="")
    {
        $menus = optional(optional(\Sina\Shuttle\Models\Menu::where('id',$id)->first())->items())->get() ?? [];
        $classes = [
            'ul' => $ul,
            'li' => $li,
            'a' => $a,
        ];
        $this->html = $this->generateMenu($menus,$classes);
    }

    private function generateMenu($menus,$classes = [], $pid = 0){
        $html = "";
        foreach ($menus as $m){
            if($m->menuable){
                $my['name'] = $m->menuable->title;
                $my['url']  = url($m->menuable->url ?? "");
            }else{
                $my['name'] = $m->title;
                $my['url']  = $m->url;
            }
            $my['children']  = count($m->children);
            if($m->pid == 0){
                $my['a_class'] = $classes["a"]." " ?? "nav-link ";
                $my['li_class'] = $classes["li"]." " ?? "nav-item " ;
            }else{
                $my['a_class'] = "dropdown-item";
                $my['li_class'] = "menu_list";
            }
//            $html .= '<li class="'.$my['li_class'].($my['children'] ? "dropdown" : "menu_list").'"><a class="'.$my['a_class'];
            $html .= '<li class="'.$my['li_class'].($my['children'] ? "has-dropdown" : "").'"><a class="'.$my['a_class'];
            if($my['children']){
                $html .= '" href="'.$my['url'].'" title="'.$my['name'].'">'.$my['name'];
                if($pid > 0){
                    $html .= ' <i class="icofont-rounded-right"></i>';
                }else{
                    $html .= ' <i class="icofont-rounded-down"></i>';
                }
                $html .= '</a><ul class="dropdown-menu">'.$this->generateMenu($m->children, [], 1).'</ul>';
            }else{
                $html .= '" href="'.$my['url'].'" title="'.$my['name'].'">'.$my['name'].'</a>';
            }
            $html .= '</li>';
        }

        return $html;
    }

    public function render()
    {
        return $this->html;
    }
}
