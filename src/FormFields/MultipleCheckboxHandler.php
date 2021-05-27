<?php

namespace Sina\Shuttle\FormFields;

class MultipleCheckboxHandler extends AbstractHandler
{
    protected $codename = 'multiple_checkbox';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('shuttle::formfields.multiple_checkbox', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
