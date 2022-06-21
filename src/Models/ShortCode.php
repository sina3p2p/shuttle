<?php

namespace Sina\Shuttle\Models;

use Thunder\Shortcode\HandlerContainer\HandlerContainer;
use Thunder\Shortcode\Parser\RegularParser;
use Thunder\Shortcode\Processor\Processor;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class ShortCode
{

    public static function parserCode($text, ScaffoldInterface $model = null, $modelSetting = [], $settings = [], $current_components = [], $component = false)
    {

        $all_components = Component::all();
        $components = $all_components->pluck('name')->toArray();
        $handlers = new HandlerContainer();
        $recursiveFunc = function ($items) use (&$recursiveFunc) {
            $newSettings = [];
            foreach ($items as $item) {
                $newSettings[] = $item;
                if ($item['type'] == 'c_relationship') {
                    $scaffold = ScaffoldInterface::where('model', $item->details->model)->first();
                    if ($scaffold) {
                        $newSettings = array_merge($newSettings, $recursiveFunc($scaffold->rows->keyBy('field')));
                    }
                } else if (!empty($item['children'])) {
                    $newSettings = array_merge($newSettings, $recursiveFunc($item['children']));
                }
            }
            return $newSettings;
        };

        $mySettings = collect($recursiveFunc($settings))->keyBy('field');
        if ($model) {
            $mySettings = $mySettings->merge($model->rows->keyBy('field'));
        }

        $mySettings = $mySettings->toArray();

        $lastIndex = 0;
        $handlers->add('component', function (ShortcodeInterface $s) use ($current_components, &$lastIndex) {
            $lastIndex = $s->getPosition() - 1;
            if (isset($current_components[$lastIndex])) {
                return "\n" . '@includeIf("components.".$page->components[' . $lastIndex . ']->name,["data" => $page->components[' . $lastIndex . ']->getComponentData($route)])';
            }
            return '';
        });
        $handlers->add('model', function (ShortcodeInterface $s) use ($modelSetting, $component) {
            if (data_get($modelSetting, 'limit', -1) == 0) {
                return $s->getContent();
            }
            if ($component) {
                return '@foreach(data_get($data,"model",[]) as $item_of_model)' . $s->getContent() . '@endforeach';
            }
            return '@foreach($data as $item_of_model)' . $s->getContent() . '@endforeach';
        });
        $handlers->setDefault(function (ShortcodeInterface $s) use ($all_components, $components, $mySettings, $modelSetting, $component) {
            if (in_array($s->getName(), $components)) {
                $c_compoenent = $all_components->where('name', $s->getName())->first();
                $m_setting = $c_compoenent->model_settings;
                if (isset($m_setting['model'])) {
                    for ($i = 0; $i < count($m_setting['model']['conditions']); $i++) {
                        $m_setting['model']['conditions'][$i]['value'] = $s->getParameter($m_setting['model']['conditions'][$i]["key"], $m_setting['model']['conditions'][$i]['value']);
                    }
                }
                //                dd($m_setting);
                return '@includeIf("components.' . $s->getName() . '",["data" => (new \Sina\Shuttle\Models\Component(["model" => ' . var_export($c_compoenent->model ?? null, true) . ', "model_settings" => ' . var_export($m_setting ?? [], true) . ']))->getComponentData()])'; //.var_export($s->getParameters() ?? [],true).'])';
                //            } elseif (key_exists($s->getName(), $mySettings) || $mySettings->has($s->getName())) {
            } elseif (key_exists($s->getName(), $mySettings)) {
                $prefix = '$data';
                if ($s->getParent() && $s->getParent()->getName() == "model" && data_get($modelSetting, 'limit', -1) == 0) {
                    $prefix = '$data';
                    if ($component) {
                        $prefix = '$data["model"]';
                    }
                } elseif ($s->getParent()) {
                    $prefix = '$item_of_' . str_replace('-', '_', optional($s->getParent())->getName());
                }

                return self::{$mySettings[$s->getName()]['type']}($s, $prefix, $mySettings[$s->getName()]);
            }
            return "";
        });
        $processor = new Processor(new RegularParser(), $handlers);
        $content = $processor->process($text);
        if (count($current_components) > $lastIndex) {
            for ($i = $lastIndex; $i < count($current_components); $i++) {
                $content .= "\n" . '<x-shuttle-dynamic-component name="' . $current_components[$i]->name . '" :data="$page->components[' . $i . ']->pivot->setting"></x-shuttle-dynamic-component>';
                // $content .= "\n" . '@includeIf("components.".$page->components[' . $i . ']->name,["data" => $page->components[' . $i . ']->getComponentData($route)])';
            }
        }

        return preg_replace(array('/ {2,}/', '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'), array(' ', ''), $content);
    }

    private static function array(ShortcodeInterface $s, $prefix, $setting = [])
    {
        return '@foreach(data_get(' . $prefix . ', "' . $s->getName() . '", []) as $item_of_' . str_replace('-', '_', $s->getName()) . ')' . $s->getContent() . '@endforeach';
    }

    private static function image(ShortcodeInterface $s, $prefix, $setting = [])
    {
        if ($s->getParameter('webp', false)) {
            return '{{Storage::url(data_get(' . $prefix . ',"' . $s->getName() . '"))}}.webp';
        }
        return '{{Storage::url(data_get(' . $prefix . ',"' . $s->getName() . '"))}}';
    }

    private static function string(ShortcodeInterface $s, $prefix, $setting = [])
    {
        return '{{data_get(' . $prefix . ',"' . $s->getName() . '")}}';
    }

    private static function text(ShortcodeInterface $s, $prefix, $setting = [])
    {
        return '{{data_get(' . $prefix . ',"' . $s->getName() . '")}}';
    }

    private static function text_area(ShortcodeInterface $s, $prefix, $setting = [])
    {
        if ($s->getParameter('html', false)) {
            return '{!! data_get(' . $prefix . ',"' . $s->getName() . '") !!}';
        }
        return '{{data_get(' . $prefix . ',"' . $s->getName() . '")}}';
    }

    private static function rich_text_box(ShortcodeInterface $s, $prefix, $setting = [])
    {
        return '{!! cleanHtml(data_get(' . $prefix . ',"' . $s->getName() . '")) !!}';
    }

    private static function html(ShortcodeInterface $s, $prefix, $setting = [])
    {
        return '{!! cleanHtml(data_get(' . $prefix . ',"' . $s->getName() . '")) !!}';
    }

    private static function timestamp(ShortcodeInterface $s, $prefix, $setting = [])
    {
        $myattr = '{{data_get(' . $prefix . ',"' . $s->getName() . '")';
        if ($s->getParameter('translation', false)) {
            $myattr .= '->locale(LaravelLocalization::getCurrentLocale())';
        }
        if ($format = $s->getParameter('format', false)) {
            $myattr .= '->isoFormat("' . $format . '")';
        }
        return $myattr . '}}';
    }

    private static function c_relationship(ShortcodeInterface $s, $prefix, $setting = [])
    {
        $details = $setting['details'];
        if ($details->type == "hasMany") {
            return '@foreach(data_get(' . $prefix . ', "' . $s->getName() . '", []) as $item_of_' . str_replace('-', '_', $s->getName()) . ')' . $s->getContent() . '@endforeach';
        }

        return "";
        //        return '{{ optional(' . $prefix . '->' . $details->column . ')->' . $details->label . ' }}';
    }

    private static function svg(ShortcodeInterface $s, $prefix, $setting = [])
    {
        return '{!! cleanHtml(data_get(' . $prefix . ',"' . $s->getName() . '")) !!}';
    }
}
