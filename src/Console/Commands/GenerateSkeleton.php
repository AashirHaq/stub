<?php

namespace Aashirhaq\Stub\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class GenerateSkeleton extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:skeleton {name : Class (singular) e.g., User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate the skeleton with views, model, migration, controller, request & service.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = Str::ucfirst(Str::singular($this->argument('name')));

        $this->controller($name);
        $this->model($name);
        $this->request($name);
        $this->service($name);
        $this->copyViews($name);
        $this->migration($name);
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__."/../../Storage/stubs/$type.stub");
    }

    protected function controller($name)
    {
        echo PHP_EOL;
        echo 'GENERATING CONTROLLER...!';
        echo PHP_EOL;

        $pluralName = Str::plural($name);

        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSlugCase}}'
            ],
            [
                $name,
                lcfirst($this->camel2dashed($pluralName))
            ],
            $this->getStub('Controller')
        );

        if(!file_exists($path = app_path('/Http/Controllers/Admin')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Controllers/Admin/{$name}Controller.php"), $template);

        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function model($name)
    {
        echo PHP_EOL;
        echo 'GENERATING MODEL...!';
        echo PHP_EOL;

        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}'
            ],
            [
                $name,
                strtolower(Str::plural($name))
            ],
            $this->getStub('Model')
        );

        if(!file_exists($path = app_path('/Models')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Models/{$name}.php"), $template);

        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function request($name)
    {
        echo PHP_EOL;
        echo 'GENERATING REQUEST...!';
        echo PHP_EOL;

        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Store.php"), $template);
        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function service($name)
    {
        echo PHP_EOL;
        echo 'GENERATING SERVICE...!';
        echo PHP_EOL;

        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Service')
        );

        if(!file_exists($path = app_path('/Http/Services')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Services/{$name}Service.php"), $template);
        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function copyViews($name)
    {
        echo PHP_EOL;
        echo 'GENERATING VIEWS...!';
        echo PHP_EOL;

        $pages = ['index', 'create', 'edit'];

        if(!file_exists($path = resource_path('/views/admin/'.strtolower(Str::plural($this->camel2dashed($name))))))
            mkdir($path, 0777, true);

        foreach($pages as $page){
            $template = str_replace(
                ['{{modelName}}'],
                [$name],
                $this->getStub($page)
            );

            file_put_contents(resource_path("/views/admin/".strtolower(Str::plural($this->camel2dashed($name))).'/'.$page.'.blade.php'), $template);
        }
        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function migration($name)
    {
        echo PHP_EOL;
        echo 'GENERATING MIGRATION...!';
        echo PHP_EOL;

        Artisan::call('make:migration create_'.Str::plural($this->camel2dashed($name)).'_table --create='.Str::plural($this->camel2dashed($name, '_')));

        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function camel2dashed($name, $seperator = '-')
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1'.$seperator, $name));
    }
}
