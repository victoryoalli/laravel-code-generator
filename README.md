

# ![Laravel Code Generator](laravel-codegenerator.png)

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
php artisan code:generate 'App\User' -t 'schema' //prints to command line
php artisan code:generate 'App\User' -t 'schema' -o 'user-schema.json'
```

**Example Output**
```json
{
  "name": "User",
  "complete_name": "App\\Models\\User",
  "table": {
    "name": "users",
    "colums": [
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
use VictorYoalli\LaravelCodeGenerator\Facades\CodeHelper;
use VictorYoalli\LaravelCodeGenerator\Facades\ModelLoader;
use VictorYoalli\LaravelCodeGenerator\Structure\Model;

function printif($type, $filename, $msg = '✖ Not generated ')
{
    echo($filename === '' ? $msg . ' : ' . $type : "✔ {$filename}") . "\n";
}

class CodeGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:generator {model : Model(s) separated by commas: i.e: \'User, Post, Section\' } ' .
            '{--namespace=App : Models Namesspace} ' .
            '{--w|views : View files} ' .
            '{--c|controller : Controller} ' .
            '{--a|api : Creates API Controller} ' .
            '{--r|routes : Display Routes} ' .
            '{--l|lang : Language} ' .
            '{--f|factory : Factory} ' .
            '{--t|tests : Feacture Test} ' .
            '{--A|all : All Files}' .
            '{--F|force : Overwrite files if exists} ' .
            '{--auth : Auth (not included in all)} ' .
            '{--event= : Event (not included in all)} ' .
            '{--notification= : Notification (not included in all)} ' .
            '{--theme=basic : Theme}';

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
        $theme = $this->option('theme');
        if ($all) {
            $lang = $factory = $controller = $routes = $views = $api = $tests = $all;
        }
        $request = ($controller || $api);

        $options = compact(['factory', 'controller', 'routes', 'views',  'api', 'tests', 'auth', 'request', 'notification', 'event', 'lang']);
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
        $folder = CodeHelper::plural(CodeHelper::snake($m->name));
        if ($option->controller) {
            printif('Web Controller', CodeGenerator::generate($m, $theme . '/Http/Controllers/ModelController', "app/Http/Controllers/{$m->name}Controller.php", $force, $options));
        }
        if ($option->api) {
            printif('API Controller', CodeGenerator::generate($m, $theme . '/Http/Controllers/API/ModelController', "app/Http/Controllers/API/{$m->name}Controller.php", $force, $options));
        }
        if ($option->request) {
            printif('Form Request', CodeGenerator::generate($m, $theme . '/Http/Requests/ModelPostRequest', "app/Http/Requests/{$m->name}PostRequest.php", $force, $options));
        }

        if ($option->views) {
            printif('Create View', CodeGenerator::generate($m, $theme . '/create', "resources/views/{$folder}/create.blade.php", $force, $options));
            printif('Edit View', CodeGenerator::generate($m, $theme . '/edit', "resources/views/{$folder}/edit.blade.php", $force, $options));
            printif('Index View', CodeGenerator::generate($m, $theme . '/index', "resources/views/{$folder}/index.blade.php", $force, $options));
            printif('Show View', CodeGenerator::generate($m, $theme . '/show', "resources/views/{$folder}/show.blade.php", $force, $options));
        }
        if ($option->lang) {
            printif('Lang', CodeGenerator::generate($m, $theme . '/lang/en/Models', "resources/lang/en/{$folder}.php", $force, $options));
        }
        if ($option->factory) {
            printif('Factory ', CodeGenerator::generate($m, $theme . '/database/factories/ModelFactory', "database/factories/{$m->name}Factory.php", $force, $options));
        }
        if ($option->tests) {
            printif('Feature Test Controller', CodeGenerator::generate($m, $theme . '/tests/Feature/Http/Controllers/ModelControllerTest', "tests/Feature/Http/Controllers/{$m->name}ControllerTest.php", $force, $options));
            printif('Feature Test API Controller', CodeGenerator::generate($m, $theme . '/tests/Feature/Http/Controllers/API/ModelControllerTest', "tests/Feature/Http/Controllers/API/{$m->name}ControllerTest.php", $force, $options));
        }
        if ($option->notification) {
            printif('Notification', CodeGenerator::generate($m, $theme . '/Notifications/ModelNotification', "app/Notifications/{$m->name}{$option->notification}.php", $force, $options));
        }
        if ($option->event) {
            printif('Event', CodeGenerator::generate($m, $theme . '/Events/ModelEvent', "app/Events/{$m->name}{$option->event}.php", $force, $options));
        }
        if ($option->routes) {
            echo CodeGenerator::generate($m, $theme . '/routes') . "\n";
        }
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

The path `resources/views/vendor/laravel-code-generator` is where you can create your own new templates, or custimize the existing ones.

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

By default you can use as templates files with following extensions, if you need to generate or use different files as templates you can added to the config file.

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
{!!CodeHelper::PHPSOL()!!}

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
            @if(!CodeHelper::contains('/_at$/',$col->name) && !CodeHelper::contains('/^id$/',$col->name))
            @if(!$col->nullable) '{{$col->name}}' => 'required',
            @endif
            @endif
            @endforeach
        ]);

        ${{CodeHelper::camel($model->name)}} = {{$model->name}}::create($request->all());

        return ${{CodeHelper::camel($model->name)}};
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
{!!CodeHelper::PHPSOL()!!}
```
Will print
```php
<?php
```

`arroba()` arroba @

```php
{{CodeHelper::arroba()}}foreach($foos as $foo)
{{CodeHelper::arroba()}}endforeach
```
Will print
```php
@foreach($foos as $foo)
@endforeach
```


`doubleCurlyOpen()`: Opening Double Curly Braces
```php
{{CodeHelper::doubleCurlyOpen()}}
```
Will print:
```php
{{
```


`doubleCurlyClose()`: Closing Double Curly Braces
```php
{{CodeHelper::doubleCurlyClose()}}
```
Will print:
```php
}}
```



`contains($regex, $text)`: Returns true when a match is found.
```
@if( CodeHelper::contains('/_at$/','created_at') )
    it's a date!
@else
    it´s not a date
@endif
```
Will print:
```
    it's a date!
```


`replace($pattern, $replacement, $subject)`: Replaces subject match with replacement text.
```php
{{CodeHelper::replace('/_id$/','','field_id')}}
```
Will print:
```php

```


`human($text)`: Converts text to readable words.
```php
{{CodeHelper::human('hello_world')}}!

{{CodeHelper::human('helloWorld')}}!
```

Will print:
```php
hello world!

hello world!
```



`title($text)`: Converts text to capitalize readable words.
```php
{{CodeHelper::human('hello_world')}}!

{{CodeHelper::human('helloWorld')}}!
```

Will print:
```php
Hello World!

Hello World!
```




`slug($text)`: Converts text to slug.
```php
{{CodeHelper::slug('hello_world')}}

{{CodeHelper::slug('Hello World')}!
```

Will print:
```php
hello-world

hello-world
```




`camel($text)`: Converts text camel case.
```php
{{CodeHelper::camel('hello_world')}}

{{CodeHelper::camel('Hello World')}!
```

Will print:
```php
helloWorld

helloWorld
```


`snake($text)`: Converts text snake case.
```php
{{CodeHelper::snake('helloWorld')}}

{{CodeHelper::snake('Hello World')}!
```

Will print:
```php
hello_world

hello_world
```





`pascal($text)`: Converts text pascal case.
```php
{{CodeHelper::pascal('hello_world')}}

{{CodeHelper::pascal('Hello World')}!
```

Will print:
```php
HelloWorld

HelloWorld
```



`singular($text)`: Converts text pascal case.
```php
{{CodeHelper::singular('people')}}

{{CodeHelper::singular('dogs')}!
```

Will print:
```php
person

dog
```




`plural($text)`: Converts text pascal case.
```php
{{CodeHelper::plural('hello_world')}}

{{CodeHelper::plural('helloWorld')}!
```

Will print:
```php
hello_worlds

helloWorlds
```


## CodeGenerator::generate Facade

This is how you can use the Facade when you want to create your own Code Generator.

```php
    $filename = CodeGenerator::generate('App\Models\User', 'basic/show', "resources/views/{$folder}/show.blade.php", false);
    $generatedCodeString = CodeGenerator::generate($m, 'basic/routes' );
```



## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
