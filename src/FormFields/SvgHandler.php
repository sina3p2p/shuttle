<?php

namespace Sina\Shuttle\FormFields;

class TextAreaHandler extends AbstractHandler
{
    protected $codename = 'svg';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('shuttle::formfields.text_area', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
