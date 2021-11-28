

# ![Laravel Code Generator](laravel-codegenerator.png)

![GitHub release (latest by date)](https://img.shields.io/github/v/release/victoryoalli/laravel-code-generator)
![Packagist Downloads](https://img.shields.io/packagist/dt/victoryoalli/laravel-code-generator)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/victoryoalli/laravel-code-generator)


Laravel Code Generator is a PHP Laravel Package that uses [Blade template](https://laravel.com/docs/8.x/blade) engine to generate code for you.

The difference between other code generators is that this one will generate the code exactly as you want it to be, same design, same lines of code.

## Demo

* [Video Tutorial Introduction (English) ](https://youtu.be/CgI7eixFexg)

## Installation

Use composer to install Laravel Code Generator.

```bash
composer require --dev victoryoalli/laravel-code-generator
```

## Usage

### Single file generation
```php
php artisan code:generate 'App\Models\User' -t 'schema' //prints to command line
php artisan code:generate 'App\Models\User' -t 'schema' -o 'user-schema.json'
```

**Example Output**
```json
{
  "name": "User",
  "complete_name": "App\\Models\\User",
  "table": {
    "name": "users",
    "columns": [
      {
        "name": "id",
        "type": "BigInt",
        "length": "",
        "nullable": "",
        "autoincrement": "1",
        "default": ""
      },
      {
        "name": "name",
        "type": "String",
        "length": "255",
        "nullable": "",
        "autoincrement": "",
        "default": ""
      },
      {
        "name": "email",
        "type": "String",
        "length": "255",
        "nullable": "",
        "autoincrement": "",
        "default": ""
      },
      {
        "name": "email_verified_at",
        "type": "DateTime",
        "length": "0",
        "nullable": "1",
        "autoincrement": "",
        "default": ""
      },
      {
        "name": "password",
        "type": "String",
        "length": "255",
        "nullable": "",
        "autoincrement": "",
        "default": ""
      },
      {
        "name": "remember_token",
        "type": "String",
        "length": "100",
        "nullable": "1",
        "autoincrement": "",
        "default": ""
      },
      {
        "name": "created_at",
        "type": "DateTime",
        "length": "0",
        "nullable": "1",
        "autoincrement": "",
        "default": ""
      },
      {
        "name": "updated_at",
        "type": "DateTime",
        "length": "0",
        "nullable": "1",
        "autoincrement": "",
        "default": ""
      }
    ]
  },
  "relations": []
}
```

### Multiple file generator

First create a custom command like this example

#### Create a Custom Command

```bash
php artisan make:command CodeGeneratorCommand --command='code:generator'
```

#### Custom Command

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\Facades\CodeGenerator;
use VictorYoalli\LaravelCodeGenerator\Facades\ModelLoader;
use VictorYoalli\LaravelCodeGenerator\Structure\Model;

class CodeGeneratorCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:generator {model : Model(s) separated by commas: i.e: \'User, Post, Section\' } ' .
            '{--namespace=App\Models : Models Namesspace} ' .
            '{--w|views : View files} ' .
            '{--c|controller : Controller} ' .
            '{--a|api : Creates API Controller} ' .
            '{--r|routes : Display Routes} ' .
            '{--l|lang : Language} ' .
            '{--A|all : All Files}' .
            '{--f|factory : Factory} ' .
            '{--t|tests : Feature Test} ' .
            '{--auth : Auth (not included in all)} ' .
            '{--event= : Event (not included in all)} ' .
            '{--notification= : Notification (not included in all)} ' .
            '{--F|force : Overwrite files if exists} ' .
            '{--livewire : Add livewire files}' .
            '{--theme=blade : Theme}';

    protected $description = 'Multiple files generation';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $force = $this->option('force');

        //Options
        $controller = $this->option('controller');
        $routes = $this->option('routes');
        $views = $this->option('views');
        $api = $this->option('api');
        $lang = $this->option('lang');
        $factory = $this->option('factory');
        $tests = $this->option('tests');
        $auth = $this->option('auth');
        $event = $this->option('event');
        $notification = $this->option('notification');
        $all = $this->option('all');
        $livewire = $this->option('livewire');
        $theme = $this->option('theme');
        if ($all) {
            $lang = $controller = $routes = $views = $all;
        }
        $request = ($controller || $api);

        $options = compact(['factory', 'controller', 'routes', 'views',  'api', 'tests', 'auth', 'request', 'notification', 'event', 'lang','livewire']);
        $namespace = rtrim($this->option('namespace'), '\\');
        $models = collect(explode(',', $this->argument('model')));

        $models->each(function ($model) use ($namespace, $options, $theme, $force) {
            $model = "{$namespace}\\{$model}";
            if (!$model) {
                return;
            }
            $m = ModelLoader::load($model);

            $this->generate($m, $options, $theme, $force);
        });
    }

    public function generate(Model $m, $options, $theme, $force)
    {
        $option = (object) $options;
        $folder = str($m->name)->plural()->snake();

        $this->info('🚀 Starting code generation');
        $this->newLine();
        if ($option->controller) {
            $this->printif('Web Controller', CodeGenerator::generate($m, $theme . '/Http/Controllers/ModelController', "app/Http/Controllers/{$m->name}Controller.php", $force, $options));
        }
        if ($option->api) {
            $this->printif('API Controller', CodeGenerator::generate($m, $theme . '/Http/Controllers/API/ModelController', "app/Http/Controllers/API/{$m->name}Controller.php", $force, $options));
        }
        if ($option->request) {
            $this->printif('Form Request', CodeGenerator::generate($m, $theme . '/Http/Requests/ModelRequest', "app/Http/Requests/{$m->name}Request.php", $force, $options));
        }

        if ($option->views) {
            $this->printif('Index View', CodeGenerator::generate($m, $theme . '/views/index', "resources/views/{$folder}/index.blade.php", $force, $options));
            $this->printif('Create View', CodeGenerator::generate($m, $theme . '/views/create', "resources/views/{$folder}/create.blade.php", $force, $options));
            $this->printif('Show View', CodeGenerator::generate($m, $theme . '/views/show', "resources/views/{$folder}/show.blade.php", $force, $options));
            $this->printif('Edit View', CodeGenerator::generate($m, $theme . '/views/edit', "resources/views/{$folder}/edit.blade.php", $force, $options));
        }
        if ($option->lang) {
            $this->printif('Lang', CodeGenerator::generate($m, $theme . '/lang/en/Models', "resources/lang/en/{$folder}.php", $force, $options));
        }
        if ($option->factory) {
            $this->printif('Factory ', CodeGenerator::generate($m, $theme . '/database/factories/ModelFactory', "database/factories/{$m->name}Factory.php", $force, $options));
        }
        if ($option->tests) {
            $this->printif('Feature Test Controller', CodeGenerator::generate($m, $theme . '/tests/Feature/Http/Controllers/ModelControllerTest', "tests/Feature/Http/Controllers/{$m->name}ControllerTest.php", $force, $options));
            if ($option->controller) {
                $this->printif('Feature Test Controller', CodeGenerator::generate($m, $theme . '/tests/Feature/Http/Controllers/ModelControllerTest', "tests/Feature/Http/Controllers/{$m->name}ControllerTest.php", $force, $options));
            }
            if ($option->api) {
                $this->printif('Feature Test API Controller', CodeGenerator::generate($m, $theme . '/tests/Feature/Http/Controllers/API/ModelControllerTest', "tests/Feature/Http/Controllers/API/{$m->name}ControllerTest.php", $force, $options));
            }
        }
        if ($option->notification) {
            $this->printif('Notification', CodeGenerator::generate($m, $theme . '/Notifications/ModelNotification', "app/Notifications/{$m->name}{$option->notification}.php", $force, $options));
        }
        if ($option->event) {
            $this->printif('Event', CodeGenerator::generate($m, $theme . '/Events/ModelEvent', "app/Events/{$m->name}{$option->event}.php", $force, $options));
        }
        if ($option->livewire) {
            $plural = str($m->name)->plural();
            $this->printif('Livewire Component ', CodeGenerator::generate($m, "/livewire/Http/Index", "app/Http/Livewire/{$plural}/Index.php", $force, $options));
            $this->printif('Livewire index view ', CodeGenerator::generate($m, "/livewire/views/index", "resources/views/livewire/{$folder}/index.blade.php", $force, $options));
            $this->printif('Livewire list view ', CodeGenerator::generate($m, "/livewire/views/list", "resources/views/livewire/{$folder}/list.blade.php", $force, $options));
            $this->printif('Livewire edit view ', CodeGenerator::generate($m, "/livewire/views/edit", "resources/views/livewire/{$folder}/edit.blade.php", $force, $options));
            $this->printif('Livewire show view ', CodeGenerator::generate($m, "/livewire/views/show", "resources/views/livewire/{$folder}/show.blade.php", $force, $options));
        }
        if ($option->routes) {
            $this->newLine(3);
            $this->line('<fg=cyan>'.CodeGenerator::generate($m, $theme . '/routes', null, $force, $options).'</>');
        }

        $this->newLine();
        $this->info('🎉 Finished!');
    }

    public function printif($type, $filename)
    {
        $text = empty($filename) ? '<fg=red> ✖ </> '. $type . '<fg=yellow> already exists </>' : '<fg=green>✔</> <fg=default>' . $filename . '<fg=magenta> created. </>';
        $this->line($text);
    }
}

```

#### Execute custom command
```bash
php artisan code:generator 'App\User' -FA
```

## Templates & Customization

Templates are located at `resources/vendor/laravel-code-generator`.
For example once you publish the views the file `schema.blade.json`  will be located at the relative path is `resources/vendor/laravel-code-generator\schema.blade.json` .

The path `resources/views/vendor/laravel-code-generator` is where you can create your own new templates, or customize the existing ones.

#### Publish template views & Config

You can publish :
```bash
## views at: resources/views/vendor/laravel-code-generator
php artisan vendor:publish --provider="VictorYoalli\LaravelCodeGenerator\LaravelCodeGeneratorServiceProvider" --tag="views"
```

or the config file
```php
## config file: config/laravel-code-generator.php
php artisan vendor:publish --provider="VictorYoalli\LaravelCodeGenerator\LaravelCodeGeneratorServiceProvider" --tag="config"
```

This is the contents of the published config file
`config/laravel-code-generator.php`:

By default you can use as templates files with following extensions, if you need to generate or use different files as templates you can add to the config file.

```php
<?php

return [
    /**
     * Extension files that can be used with this Blade template engine.
     * You can add more if you need to.
     * .blade.php
     * .blade.js
     * .blade.jsx
     * .blade.vue
     * .blade.html
     * .blade.txt
     * .blade.json
     */
    'extensions' => [
        'js',
        'jsx',
        'vue',
        'html',
        'txt',
        'json',
    ]
];
```
## Structure
* **Model** *(object)*
  * name *(string)*
  * table *(object)*
  * relations *(array)*
* **Table** *(object)*
  * name *(string)*
  * columns *(array)*
* **Column** *(object)*
  * name *(string)*
  * type *(string)*
  * length *(integer)*
  * nullable *(boolean)*
  * autoincrement *(boolean)*
  * default *(string)*
* **Relations** *(array)*
  * name *(string)*
  * type *(string)*
  * local_key *(string)*
  * foreign_key *(string)*
  * model *(array)*

#### Example
```php
{!!code()->PHPSOL()!!}

namespace App\Http\Controllers\API;

use App\{{$model->name}};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class {{$model->name}}Controller extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return {{$model->name}}::all();
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            @foreach($model->table->columns as $col)
            @if(!str($col->name)->matches('/_at$/') && !str($col->name)->matches('/^id$/'))
            @if(!$col->nullable) '{{$col->name}}' => 'required',
            @endif
            @endif
            @endforeach
        ]);

        ${{str($model->name)->camel()}} = {{$model->name}}::create($request->all());

        return ${{str($model->name)->camel()}};
    }

...
}

```

#### Output Sample

```php
<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return  \Illuminate\Http\Response
    */
    public function index()
    {
        return User::all();
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return  \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',

        ]);

        $user = User::create($request->all());

        return $user;
    }

```


## Helpers

`PHPSOL()`: PHP Start Of Line

```php
{!!code->PHPSOL()!!}
```
Will print
```php
<?php
```

`doubleCurlyOpen()`: Opening Double Curly Braces
```php
{{code()->doubleCurlyOpen()}}
```
Will print:
```php
{{
```


`doubleCurlyClose()`: Closing Double Curly Braces
```php
{{code()->doubleCurlyClose()}}
```
Will print:
```php
}}
```

`tag('x-component-name')`: Closing Double Curly Braces
```php
{{code()->tag('x-component-name)}}
```
Will print:
```php
<x-component-name>
```




## CodeGenerator::generate Facade

This is how you can use the Facade when you want to create your own Code Generator.

```php
    $filename = CodeGenerator::generate('App\Models\User', 'blade/show', "resources/views/{$folder}/show.blade.php", false);
    $generatedCodeString = CodeGenerator::generate($m, 'blade/routes' );
```



## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
