<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sina\Shuttle\Models\Page;
use Sina\Shuttle\Models\QueryBuilder;

class HomeController extends BaseController
{
    public function index(Request $request)
    {
        $data = [];
        $languages = config('laravellocalization.supportedLocales');
        $route = array_filter(explode('/',$request->path()));
        if (key_exists($route[0] ?? '', $languages)) {
            array_shift($route);
        }

        
        if(data_get($route, 0) == "api"){
            array_shift($route);
        }
        
        if(!isset($route[0])) {
            $route[0] = 'home';
        }
        $qbp = new QueryBuilder([], $route, $request->all());
        $lang = LaravelLocalization::getCurrentLocale();
        $page = $page = Page::where('url', $route[0])->with(['type', 'components' => function($q) use ($lang) {
            $q->wherePivot('locale',$lang);
        }])->firstOrFail();
        $include_file = 'sections/'.$lang.'/'.$page->id;
        if($page->type) {
            if ($page->type->sections->count() < count($route)) {
                abort(404);
            }
            $section = $page->type->sections[count($route) - 1];
            $model = $section->model;
            if(count($route) - 1 > 0){
                $include_file = 'sections/'.$section->id;
            }
            if($model) {
                $table = app($page->type->model);
                $query = $qbp->parse(data_get($model,'rules', '{}'), $table);
                $limit = data_get($model, 'limit', -1);
                $query = $query->orderBy(data_get($model,'order', 'created_at'),data_get($model,'dir', 'DESC'));
                switch ($limit) {
                    case 0:
                        $data = $query->firstOrFail();
                        if($data && method_exists($data,'views')){
                            views($data)->record();
                        }
                        break;
                    case -1:
                        $data = $query->get();
                        break;
                    default:
                        $data = $query->paginate($limit);
                }
            }
        }

        if($this->is_api)
        {
            return [
                'data' => $data,
                'page' => $page
            ];
        }

        return view('index', compact('data','page', 'lang','route','include_file'));
    }
}
