<?php

namespace Sina\Shuttle\FormFields;

class CoordinatesHandler extends AbstractHandler
{
    protected $supports = [
        'mysql',
        'pgsql',
    ];

    protected $codename = 'coordinates';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('shuttle::formfields.coordinates', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
