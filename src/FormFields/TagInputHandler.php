<?php

namespace Sina\Shuttle\FormFields;

class TagInputHandler extends AbstractHandler
{
    protected $codename = 'tagInput';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('shuttle::formfields.tag_input', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
