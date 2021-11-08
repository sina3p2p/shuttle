<?php

namespace Sina\Shuttle\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Sina\Shuttle\Facades\Shuttle;
use Sina\Shuttle\Models\ScaffoldInterface;

class InstallShuttlePackage extends Command
{
    protected $signature = 'shuttle:install';

    protected $description = 'Install the Shuttle';

    public function handle()
    {
        $this->info('Installing Shuttle...');

        // $this->info('Initialize basic scaffolds...');

        // foreach(Shuttle::getDefaultScaffolds() as $name => $scaffold)
        // {
        //     $scaffold['name'] = $name;
        //     $scaffold['slug'] = Str::slug($name);
        //     $scaffold['display_name_singular'] = Str::singular($name);
        //     $scaffold['display_name_plural'] = Str::plural($name);
        //     ScaffoldInterface::updateOrCreate([
        //         'name' => $name
        //     ], $scaffold);
        // }

        // $this->info('Initialize basic scaffolds Completed');

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

        \Sina\Shuttle\Models\Admin::create([
            'name'       => 'Sina',
            'email'      => 'sinaparsa9991@yahoo.com',
            'role'       => 'developer',
            'password'   => bcrypt('admin123'),
        ]);

        $this->info('Installed Shuttle successfully; Make a your idea true :D');
    }

    protected function makeAdminScaffold()
    {

    }

}
