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
        $name = Str::title($this->argument('name'));

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

        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );

        if(!file_exists($path = app_path('/Http/Controllers/Admin')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Controllers/Admin/{$name}Controller.php"), $controllerTemplate);

        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function model($name)
    {
        echo PHP_EOL;
        echo 'GENERATING MODEL...!';
        echo PHP_EOL;

        $modelTemplate = str_replace(
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

        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);

        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function request($name)
    {
        echo PHP_EOL;
        echo 'GENERATING REQUEST...!';
        echo PHP_EOL;

        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Store.php"), $requestTemplate);
        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function service($name)
    {
        echo PHP_EOL;
        echo 'GENERATING SERVICE...!';
        echo PHP_EOL;

        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Service')
        );

        if(!file_exists($path = app_path('/Http/Services')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Services/{$name}Service.php"), $requestTemplate);
        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function copyViews($name)
    {
        echo PHP_EOL;
        echo 'GENERATING VIEWS...!';
        echo PHP_EOL;

        $pages = ['index', 'create', 'edit'];
        if(!file_exists($path = resource_path('/views/admin/'.strtolower(Str::plural($this->hyphenConvert($name))))))
            mkdir($path, 0777, true);
        foreach($pages as $page){
            $requestTemplate = str_replace(
                ['{{modelName}}'],
                [$name],
                $this->getStub($page)
            );

            file_put_contents(resource_path("/views/admin/".strtolower(Str::plural($this->hyphenConvert($name))).'/'.$page.'.blade.php'), $requestTemplate);

        }
        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function migration($name){
        echo PHP_EOL;
        echo 'GENERATING MIGRATION...!';
        echo PHP_EOL;

        Artisan::call('make:migration create_'.Str::plural(strtolower($name)).'_table --create='.Str::plural(strtolower($name)));

        echo '****** DONE ******';
        echo PHP_EOL;
    }

    protected function hyphenConvert($name){
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $name));
    }
}
