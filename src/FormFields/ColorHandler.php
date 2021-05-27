<?php

namespace Sina\Shuttle\FormFields;

class ColorHandler extends AbstractHandler
{
    protected $codename = 'color';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('shuttle::formfields.color', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
