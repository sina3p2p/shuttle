<?php

namespace Sina\Shuttle\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallShuttlePackage extends Command
{
    protected $signature = 'shuttle:install';

    protected $description = 'Install the Shuttle';

    public function handle()
    {
        $this->info('Installing Shuttle...');

        $this->info('Initialize basic scaffolds...');


//        $this->call('vendor:publish', [
//            '--provider' => "JohnDoe\BlogPackage\BlogPackageServiceProvider",
//            '--tag' => "config"
//        ]);

        $this->call('vendor:publish', [
            '--provider' => "Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
        ]);

        foreach (['en', 'ka', 'ru'] as $lang){
            $sourceFile = resource_path("views/sections/".$lang);
            if(!File::isDirectory($sourceFile)){
                File::makeDirectory($sourceFile);
            }
        }

        $this->call('vendor:publish', [
            '--tag' => "translatable"
        ]);

        $this->call('vendor:publish', [
            '--provider' => "Sina\Shuttle\ShuttleServiceProvider",
            '--tag' => "app"
        ]);

        $this->info('Installed Shuttle successfully; Make a your idea true :D');
    }

    protected function makeAdminScaffold()
    {

    }

}
