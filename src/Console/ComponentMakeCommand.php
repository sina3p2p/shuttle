<?php

namespace Sina\Shuttle\Console;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Sina\Shuttle\Facades\Shuttle;
use Sina\Shuttle\Models\ScaffoldInterface;

class ComponentMakeCommand extends GeneratorCommand
{
    protected $name = 'make:shuttle-component';

    protected $description = 'Make component';

    protected $type = 'Shuttle Component';

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/component.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\View\\Shuttle';
    }


}
