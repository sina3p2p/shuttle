<?php
namespace Sina\Shuttle\Http\Traits;

use App\Component;
use App\ScaffoldInterface;
use Illuminate\Support\Arr;
use Thunder\Shortcode\Event\FilterShortcodesEvent;
use Thunder\Shortcode\Event\ReplaceShortcodesEvent;
use Thunder\Shortcode\Events;
use Thunder\Shortcode\Handler\RawHandler;
use Thunder\Shortcode\HandlerContainer\HandlerContainer;
use Thunder\Shortcode\Parser\RegularParser;
use Thunder\Shortcode\Processor\Processor;
use Thunder\Shortcode\Shortcode\ReplacedShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Thunder\Shortcode\ShortcodeFacade;

trait ShortCodeTrait {

    public function parserContent($text,$lang = 'ka',ScaffoldInterface $model = null)
    {
        $i = 0;
        $parser = new RegularParser();
        $componentsSetting = function ($parsText,$parent = false) use (&$componentsSetting,$parser) {
            $settings = array();
            $savedBefore = ['model', 's-link'];
            foreach ($parsText as $c){
                if(in_array($c->getName(),$savedBefore)){ continue; }
                $res2 = [];
                if($c->getContent()){
                    $res2 = $componentsSetting($parser->parse($c->getContent()));
                }
                $s = array_merge($c->getParameters(),$res2);
                if($parent) {
                    $settings[$c->getName()] = $s;
                }else{
                    $settings[$c->getName()][] = $s;
                }
            }
            return $settings;
        };

        $handlers = new HandlerContainer();


        $addHandler = function ($attr) use (&$handlers,&$addHandler) {
            $prefix = '$model';
            foreach ($attr as $key=>$val){
                $handlers->add($key, function (ShortcodeInterface $s) use ($val,$key,$prefix) {
                    if($s->getParent() != null && $s->getParent()->getParameter('type', 'multi') == "single"){
                        $prefix = '$data';
                    }
                    switch ($val){
                        case "media":
                        case "image":
                            return '{{Storage::url('.$prefix.'->'.$key.')}}';
                            break;
                        case "rich_text_box":
                        case "html":
                            return '{!! '.$prefix.'->'.$key.' !!}';
                            break;
                        case "views":
                            return '{{views('.$prefix.')->unique()->count()}}';
                            break;
                        case "timestamp":
                            $myattr = '{{data_get('.$prefix.', "'.$key.'")';
                            if($s->getParameter('translation',false)){
                                $myattr .= '->locale(LaravelLocalization::getCurrentLocale())';
                            }
                            if($format = $s->getParameter('format',false)){
                                $myattr .= '->isoFormat("'.$format.'")';
                            }
                            $myattr .= '}}';
                            return $myattr;
                            break;

                    }
                    return '{{'.$prefix.'->'.$key.'}}';
                });
            }
        };

        if($model) {
            $handlers->add('model', function (ShortcodeInterface $s) {
                if($s->getParameter('type','multi') == 'single'){
                    return $s->getContent();
                }
                return '@foreach($data as $model)' . $s->getContent() . '@endforeach';
            });

//            $addHandler(array_merge(Arr::pluck($model->columns ,'type','name'),Arr::pluck($model->translates, 'type','name')));

            $modelSettings = $model->rows->pluck('type','field')->toArray();//array_merge($model->columns,$model->translates);
            $modelSettings['views'] = 'views';
            $addHandler($modelSettings);
        }

        $handlers->add('s-link', function (ShortcodeInterface $s) {
            return '{{url($page->url,$data->'.$s->getParameter('by','url').')}}';
        });

        $handlers->add('p-link', function (ShortcodeInterface $s) {
            return '{{$page->url}}';
        });

//        $handlers->add('component', function (ShortcodeInterface $s) {
//            return '{{$page->url}}';
//        });

        $thisSectionComponent = $componentsSetting($parser->parse($text),true);

        $syncArr = array();
        $components = Component::select('name','id')->whereIn('name',array_keys($thisSectionComponent))->get()->pluck('id','name');

        $i=0;
        foreach ($thisSectionComponent as $key => $component) {
            $syncArr[$components[$key]] =  ['setting' => $component, 'locale' => $lang, 'position' => $i];
            $handlers->add($key, function (ShortcodeInterface $s) use ($components) {
                return '@includeIf("components.'.$s->getName().'",["data" => $section->components->where("pivot.component_id",'.$components[$s->getName()].')->first()->getComponentData($route)])';
            });
            $i++;
        }

        $processor = new Processor(new RegularParser(), $handlers);

        $processor = $processor->withAutoProcessContent(true);

        $content = $processor->process($text);

        return ['content' => $content, 'components' => $syncArr];

    }

    public function parserContent2($text,$lang = 'ka', $sectionComponents = [],ScaffoldInterface $model = null)
    {

        $parser = new RegularParser();
//        $componentsSetting = function ($parsText,$parent = false) use (&$componentsSetting,$parser) {
//            $settings = array();
//            $savedBefore = ['model', 's-link'];
//            foreach ($parsText as $c){
//                if(in_array($c->getName(),$savedBefore)){ continue; }
//                $res2 = [];
//                if($c->getContent()){
//                    $res2 = $componentsSetting($parser->parse($c->getContent()));
//                }
//                $s = array_merge($c->getParameters(),$res2);
//                if($parent) {
//                    $settings[$c->getName()] = $s;
//                }else{
//                    $settings[$c->getName()][] = $s;
//                }
//            }
//            return $settings;
//        };

        $handlers = new HandlerContainer();


        $addHandler = function ($attr) use (&$handlers,&$addHandler) {
            $prefix = '$model';
            foreach ($attr as $key=>$val){
                $handlers->add($key, function (ShortcodeInterface $s) use ($val,$key,$prefix) {
                    if($s->getParent() != null && $s->getParent()->getParameter('type', 'multi') == "single"){
                        $prefix = '$data';
                    }
                    switch ($val){
                        case "media":
                        case "image":
                            return '{{Storage::url('.$prefix.'->'.$key.')}}';
                            break;
                        case "rich_text_box":
                        case "html":
                            return '{!! '.$prefix.'->'.$key.' !!}';
                            break;
                        case "views":
                            return '{{views('.$prefix.')->unique()->count()}}';
                            break;
                        case "timestamp":
                            $myattr = '{{data_get('.$prefix.', "'.$key.'")';
                            if($s->getParameter('translation',false)){
                                $myattr .= '->locale(LaravelLocalization::getCurrentLocale())';
                            }
                            if($format = $s->getParameter('format',false)){
                                $myattr .= '->isoFormat("'.$format.'")';
                            }
                            $myattr .= '}}';
                            return $myattr;
                            break;

                    }
                    return '{{'.$prefix.'->'.$key.'}}';
                });
            }
        };

        if($model) {
            $handlers->add('model', function (ShortcodeInterface $s) {
                if($s->getParameter('type','multi') == 'single'){
                    return $s->getContent();
                }
                return '@foreach($data as $model)' . $s->getContent() . '@endforeach';
            });

//            $addHandler(array_merge(Arr::pluck($model->columns ,'type','name'),Arr::pluck($model->translates, 'type','name')));

            $modelSettings = $model->rows->pluck('type','field')->toArray();//array_merge($model->columns,$model->translates);
            $modelSettings['views'] = 'views';
            $addHandler($modelSettings);
        }

        $handlers->add('s-link', function (ShortcodeInterface $s) {
            return '{{url($page->url,$data->'.$s->getParameter('by','url').')}}';
        });

        $handlers->add('p-link', function (ShortcodeInterface $s) {
            return '{{$page->url}}';
        });

        $lastIndex = 0;
        $handlers->add('component', function (ShortcodeInterface $s) use ($sectionComponents,&$lastIndex){
            $lastIndex = $s->getPosition() - 1;
            if(isset($sectionComponents[$lastIndex])){
                $c = $sectionComponents[$lastIndex];
                return '@includeIf("components.'.$c->name.'",["data" => $section->components['.$lastIndex.']->getComponentData($route)])';
            }
            return '';
        });

//        $thisSectionComponent = $componentsSetting($parser->parse($text),true);

//        $syncArr = array();
//        $components = Component::select('name','id')->whereIn('name',array_keys($thisSectionComponent))->get()->pluck('id','name');
//
//        $i=0;
        foreach (Component::all() as $key => $component) {
//            $syncArr[$component->name] =  ['setting' => $component, 'locale' => $lang, 'position' => $i];
            $handlers->add($component->name, function (ShortcodeInterface $s) use ($component) {
                dd($component->id);
                return '@includeIf("components.'.$s->getName().'",["data" => $section->components->where("pivot.component_id",'.$component->id.')->first()->getComponentData($route)])';
            });
//            $i++;
        }

        $processor = new Processor(new RegularParser(), $handlers);

        $processor = $processor->withAutoProcessContent(true);

        $content = $processor->process($text);

        if(count($sectionComponents) > $lastIndex + 1){
            for($i=$lastIndex;$i<count($sectionComponents);$i++)
            {
                $content .= "\n".'@includeIf("components.".$section->components['.$i.']->name,["data" => $section->components['.$i.']->getComponentData($route)])';
            }
        }
//        dd($lastIndex);

        return $content;

    }

    public function parserContent3($text,ScaffoldInterface $model = null,$current_components = [])
    {

//        $parser = new RegularParser();

        $handlers = new HandlerContainer();

        $addHandler = function ($attr) use (&$handlers,&$addHandler) {
            $prefix = '$model';
            foreach ($attr as $key=>$val){
                $handlers->add($key, function (ShortcodeInterface $s) use ($val,$key,$prefix) {
                    if($s->getParent() != null && $s->getParent()->getParameter('type', 'multi') == "single"){
                        $prefix = '$data';
                    }
                    switch ($val){
                        case "media":
                        case "image":
                            return '{{Storage::url('.$prefix.'->'.$key.')}}';
                            break;
                        case "rich_text_box":
                        case "html":
                            return '{!! '.$prefix.'->'.$key.' !!}';
                            break;
                        case "views":
                            return '{{views('.$prefix.')->unique()->count()}}';
                            break;
                        case "timestamp":
                            $myattr = '{{data_get('.$prefix.', "'.$key.'")';
                            if($s->getParameter('translation',false)){
                                $myattr .= '->locale(LaravelLocalization::getCurrentLocale())';
                            }
                            if($format = $s->getParameter('format',false)){
                                $myattr .= '->isoFormat("'.$format.'")';
                            }
                            $myattr .= '}}';
                            return $myattr;
                            break;
                    }
                    return '{{'.$prefix.'->'.$key.'}}';
                });
            }
        };

        if($model) {
            $handlers->add('model', function (ShortcodeInterface $s) {
                if($s->getParameter('type','multi') == 'single'){
                    return $s->getContent();
                }
                return '@foreach($data as $model)' . $s->getContent() . '@endforeach';
            });

//            $addHandler(array_merge(Arr::pluck($model->columns ,'type','name'),Arr::pluck($model->translates, 'type','name')));

            $modelSettings = $model->rows->pluck('type','field')->toArray();
            $modelSettings['views'] = 'views';
            $addHandler($modelSettings);
        }

        $handlers->add('s-link', function (ShortcodeInterface $s) {
            return '{{url($page->url,$data->'.$s->getParameter('by','url').')}}';
        });

        $handlers->add('p-link', function (ShortcodeInterface $s) {
            return '{{$page->url}}';
        });

        $lastIndex = 0;
        $handlers->add('component', function (ShortcodeInterface $s) use ($current_components,&$lastIndex){
            $lastIndex = $s->getPosition() - 1;
            if(isset($current_components[$lastIndex])){
                return "\n".'@includeIf("components.".$section->components['.$lastIndex.']->name,["data" => $section->components['.$lastIndex.']->getComponentData($route)])';
            }
            return '';
        });

//        $thisSectionComponent = $componentsSetting($parser->parse($text),true);

//        $syncArr = array();
//        $components = Component::select('name','id')->whereIn('name',array_keys($thisSectionComponent))->get()->pluck('id','name');
//
//        $i=0;
        foreach (Component::all() as $key => $component) {
//            $syncArr[$component->name] =  ['setting' => $component, 'locale' => $lang, 'position' => $i];
            $handlers->add($component->name, function (ShortcodeInterface $s) use ($component) {
                return '@includeIf("components.'.$s->getName().'",["data" =>'.var_export($s->getParameters() ?? [],true).'])';
            });
//            $i++;
        }

        $processor = new Processor(new RegularParser(), $handlers);

        $processor = $processor->withAutoProcessContent(true);

        $content = $processor->process($text);

        if(count($current_components) > $lastIndex + 1){
            for($i=$lastIndex;$i<count($current_components);$i++)
            {
                $content .= "\n".'@includeIf("components.".$page->components['.$i.']->name,["data" => $page->components['.$i.']->getComponentData($route)])';
            }
        }

        return $content;

    }


    public function parserContent4($text,ScaffoldInterface $model = null,$modelSetting = [], $settings = [],$current_components = [], $component = false)
    {
        $all_components = Component::all();
        $components = $all_components->pluck('name')->toArray();
        $handlers = new HandlerContainer();
        $recursiveFunc = function ($items) use(&$recursiveFunc) {
            $newSettings = [];
            foreach ($items as $item) {
                $newSettings[] = $item;
                if (!empty($item['objects'])) {
                    $newSettings = array_merge($newSettings, $recursiveFunc($item['objects']));
                }
            }
            return $newSettings;
        };
//        $mySettings = collect($recursiveFunc($settings));
        $mySettings = collect($recursiveFunc($settings))->keyBy('key');
        if($model) {
            $mySettings = $mySettings->merge($model->rows->keyBy('field'));
        }

        $mySettings = $mySettings->toArray();

        $lastIndex = 0;
        $handlers->add('component', function (ShortcodeInterface $s) use ($current_components,&$lastIndex){
            $lastIndex = $s->getPosition();
            if(isset($current_components[$lastIndex])){
                return "\n".'@includeIf("components.".$section->components['.$lastIndex.']->name,["data" => $section->components['.$lastIndex.']->getComponentData($route)])';
            }
            return '';
        });
        $handlers->add('model', function (ShortcodeInterface $s) use ($modelSetting,$component){
            if(data_get($modelSetting,'limit', -1) == 0){
                return $s->getContent();
            }
            if($component){
                return '@foreach(data_get($data,"model",[]) as $item_of_model)'.$s->getContent().'@endforeach';
            }
            return '@foreach($data as $item_of_model)'.$s->getContent().'@endforeach';
        });
        $handlers->setDefault(function(ShortcodeInterface $s) use ($all_components,$components, $mySettings,$modelSetting, $component) {
            if(in_array($s->getName(),$components)){
                $c_compoenent = $all_components->where('name', $s->getName())->first();
                return '@includeIf("components.'.$s->getName().'",["data" => (new \App\Component(["model" => '.var_export($c_compoenent->model ?? null, true).', "model_settings" => '.var_export($c_compoenent->model_settings ?? [], true).']))->getComponentData()])';//.var_export($s->getParameters() ?? [],true).'])';
            }elseif (key_exists($s->getName(),$mySettings) || $mySettings->has($s->getName())){
                $prefix = '$data';
                if($s->getParent() && $s->getParent()->getName() == "model" && data_get($modelSetting,'limit', -1) == 0){
                    $prefix = '$data';
                    if($component){
                        $prefix = '$data["model"]';
                    }
                }elseif ($s->getParent()){
                    $prefix = '$item_of_'.str_replace('-','_', optional($s->getParent())->getName());
                }
                return $this->{$mySettings[$s->getName()]['type']}($s, $prefix, $mySettings[$s->getName()]);
            }
            return "";
        });
        $processor = new Processor(new RegularParser(), $handlers);
        $content = $processor->process($text);
        if(count($current_components) > $lastIndex){
            for($i=$lastIndex;$i<count($current_components);$i++)
            {
                $content .= "\n".'@includeIf("components.".$page->components['.$i.']->name,["data" => $page->components['.$i.']->getComponentData($route)])';
            }
        }
        return preg_replace(array('/ {2,}/', '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'), array(' ', ''), $content);
    }

    private function array(ShortcodeInterface $s, $prefix, $setting = []){
        return '@foreach(data_get('.$prefix.', "'.$s->getName().'", []) as $item_of_'.str_replace('-','_',$s->getName()).')' . $s->getContent() . '@endforeach';
    }

    private function image(ShortcodeInterface $s, $prefix, $setting = []){
        if($s->getParameter('webp',false)){
            return '{{Storage::url(data_get('.$prefix.',"'.$s->getName().'"))}}.webp';
        }
        return '{{Storage::url(data_get('.$prefix.',"'.$s->getName().'"))}}';
    }

    private function string(ShortcodeInterface $s, $prefix, $setting = []){
        return '{{data_get('.$prefix.',"'.$s->getName().'")}}';
    }

    private function text(ShortcodeInterface $s, $prefix, $setting = []){
        return '{{data_get('.$prefix.',"'.$s->getName().'")}}';
    }

    private function text_area (ShortcodeInterface $s, $prefix, $setting = []){
        return '{{data_get('.$prefix.',"'.$s->getName().'")}}';
    }

    private function rich_text_box (ShortcodeInterface $s, $prefix, $setting = []){
        return '{!! cleanHtml(data_get('.$prefix.',"'.$s->getName().'")) !!}';
    }

    private function html (ShortcodeInterface $s, $prefix, $setting = []){
        return '{!! cleanHtml(data_get('.$prefix.',"'.$s->getName().'")) !!}';
    }

    private function timestamp(ShortcodeInterface $s, $prefix, $setting = []){
        $myattr = '{{data_get('.$prefix.',"'.$s->getName().'")';
        if($s->getParameter('translation',false)){
            $myattr .= '->locale(LaravelLocalization::getCurrentLocale())';
        }
        if($format = $s->getParameter('format',false)){
            $myattr .= '->isoFormat("'.$format.'")';
        }
        return $myattr.'}}';
    }

    private function relationship(ShortcodeInterface $s, $prefix, $setting = [])
    {
        $details = json_decode($setting['details']);
        return '{{ optional('.$prefix.'->'.$details->table.')->'.$s->getParameter('attr') ?? $details->label.' }}';
    }

    public function parserComponents($text,ScaffoldInterface $model = null,$settings = [])
    {

        $handlers = new HandlerContainer();

        $addHandler = function ($attr, $array = [],$foreach = "") use (&$handlers,&$addHandler) {
            $prefix = ($foreach != "") ? $foreach : '$data';
            $itemName = '$item_'.rand ( 0 , 100);
            foreach ($attr as $key=>$val2){
                $handlers->add($key, function (ShortcodeInterface $s) use ($val2,$key,$prefix,$itemName) {
                    switch ($val2){
                        case "image":
                            return '{{Storage::url(data_get('.$prefix.',"'.$key.'"))}}';
                            break;
                        case "rich_text_box":
                        case "html":
                            return '{!! data_get('.$prefix.',"'.$key.'") !!}';
                            break;
                        case "timestamp":
                            $myattr = '{{data_get('.$prefix.', "'.$key.'")';
                            if($s->getParameter('translation',false)){
                                $myattr .= '->locale(LaravelLocalization::getCurrentLocale())';
                            }
                            if($format = $s->getParameter('format',false)){
                                $myattr .= '->isoFormat("'.$format.'")';
                            }
                            $myattr .= '}}';
                            return $myattr;
                            break;
                        case "array":
                            return '@foreach(data_get('.$prefix.',"'.$key.'", []) as '.$itemName.')'.$s->getContent().'@endforeach';
                            break;
                        case "views":
                            return '{{views('.$prefix.')->unique()->count()}}';
                            break;
//
                    }
                    return '{{data_get('.$prefix.', "'.$key.'")}}';
                });
                if($val2 == "array"){
                    $first = Arr::first($array, function ($value) use ($key){
                        return $value['key'] == $key;
                    });
                    $newArray = data_get($first,'objects',[]);
                    $addHandler(Arr::pluck($newArray,'type','key'), $newArray, $itemName);
                }
            }
        };


        if($model) {
            $handlers->add('model', function (ShortcodeInterface $s) {
                if($s->getParameter('type','multi') == 'single'){
                    return $s->getContent();
                }
                return '@foreach(data_get($data,"model",[]) as $item)' . $s->getContent() . '@endforeach';
            });

//            dd($model->rows->pluck('type','field')->toArray());
            $modelSettings = $model->rows->pluck('type','field')->toArray();//array_merge($model->columns,$model->translates);
//            $modelSettings = Arr::add(Arr::pluck($modelSettings ,'type','name'),'created_at','date');
//            dd($modelSettings);
            $modelSettings['views'] = 'views';
            $addHandler($modelSettings, $modelSettings,'$item');

        }

        $addHandler(Arr::pluck($settings ,'type','key'),$settings);


        $handlers->add('s-link', function (ShortcodeInterface $s) {
            return '{{url($page->url,$model->'.$s->getParameter('by','url').')}}';
        });

        $handlers->add('p-link', function (ShortcodeInterface $s) {
            return '{{$page->url}}';
        });

        $handlers->add('loop', function (ShortcodeInterface $s) {
            if($s->getParameter('type','zero') == 'one'){
                return '{{$loop->iteration}}';
            }
            return '{{$loop->index}}';
        });


        $processor = new Processor(new RegularParser(), $handlers);

        $processor = $processor->withAutoProcessContent(true);

        $content = $processor->process($text);

        return $content;

    }
}
