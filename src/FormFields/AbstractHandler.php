<?php

namespace Sina\Shuttle\FormFields;

use Illuminate\Support\Str;
use Sina\Shuttle\Http\Traits\Renderable;

abstract class AbstractHandler implements HandlerInterface
{
    use Renderable;

    protected $name;
    protected $codename;
    protected $supports = [];

    public function handle2($name, $value, $option)
    {
        $content = $this->createContent2(
            $name,
            $value,
            $option,
            // json_decode($row->details,false)
            // $row->details
        );

        return $this->render($content);
    }

    public function handle($row, $dataType, $dataTypeContent)
    {
        $content = $this->createContent(
            $row,
            $dataType,
            $dataTypeContent,
            // json_decode($row->details,false)
            $row->details
        );

        return $this->render($content);
    }

    public function supports($driver)
    {
        if (empty($this->supports)) {
            return true;
        }

        return in_array($driver, $this->supports);
    }

    public function getCodename()
    {
        if (empty($this->codename)) {
            $name = class_basename($this);

            if (Str::endsWith($name, 'Handler')) {
                $name = substr($name, 0, -strlen('Handler'));
            }

            $this->codename = Str::snake($name);
        }

        return $this->codename;
    }

    public function getName()
    {
        if (empty($this->name)) {
            $this->name = ucwords(str_replace('_', ' ', $this->getCodename()));
        }

        return $this->name;
    }
}
