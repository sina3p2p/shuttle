<?php

namespace Sina\Shuttle\FormFields;

class CodeEditorHandler extends AbstractHandler
{
    protected $codename = 'code_editor';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('shuttle::formfields.code_editor', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
