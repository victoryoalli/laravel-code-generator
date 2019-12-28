# Laravel Code Generator

Laravel Code Generator is a PHP Laravel Package that uses Blade template engine to generate code for you.

## Installation

Use composer to install Laravel Code Generator.

```bash
composer require --dev victoryoalli/laravel-code-generator
```

You can publish views and config with:
```bash
php artisan vendor:publish --provider="VictorYoalli\LaravelCodeGenerator" --tag=views,config --force
```


This is the contents of the published config file
`config/laravel-code-generator.php`:

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

## Usage

#### Command Basic Usage
```php
php artisan code:generate 'App\User' -t 'schema' //prints to command line
php artisan code:generate 'App\User' -t 'schema' -o 'user-schema.json'
```
Will look for the template located at `resources/vendor/laravel-code-generator` in this case would be the file schema.blade.json where the relative path is `resources/vendor/laravel-code-generator\schema.blade.json`

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
  * models *(array)*

## Templates
Once you publish the default templates you can modify or create new ones. Templates can be found and should be located at `resources/views/vendor/laravel-code-generator`.

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
Will produce
```php
<?php
```


`doubleCurlyOpen()`: Opening Double Curly Braces
```php
{{CodeHelper::doubleCurlyOpen()}}
```
Will produce:
```php
{{
```


`doubleCurlyClose()`: Closing Double Curly Braces
```php
{{CodeHelper::doubleCurlyClose()}}
```
Will produce:
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
Will produce:
```
    it's a date!
```


`replace($pattern, $replacement, $subject)`: Replaces subject match with replacement text.
```php
{{CodeHelper::replace('/_id$/','','field_id')}}
```
Will produce:
```php

```


`human($text)`: Converts text to readable words.
```php
{{CodeHelper::human('hello_world')}}!

{{CodeHelper::human('helloWorld')}}!
```

Will produce:
```php
hello world!

hello world!
```

`title($text)`: Converts text to capitalize readable words.
```php
{{CodeHelper::human('hello_world')}}!

{{CodeHelper::human('helloWorld')}}!
```

Will produce:
```php
Hello World!

Hello World!
```




`slug($text)`: Converts text to slug.
```php
{{CodeHelper::slug('hello_world')}}

{{CodeHelper::slug('Hello World')}!
```

Will produce:
```php
hello-world

hello-world
```


`camel($text)`: Converts text camel case.
```php
{{CodeHelper::camel('hello_world')}}

{{CodeHelper::camel('Hello World')}!
```

Will produce:
```php
helloWorld

helloWorld
```


`pascal($text)`: Converts text pascal case.
```php
{{CodeHelper::camel('hello_world')}}

{{CodeHelper::camel('Hello World')}!
```

Will produce:
```php
HelloWorld

HelloWorld
```


`plural($text)`: Converts text pascal case.
```php
{{CodeHelper::plural('hello_world')}}

{{CodeHelper::plural('helloWorld')}!
```

Will produce:
```php
hello_worlds

helloWorlds
```


## Multiple files generation example

### Instructions
Create a Custom Command
```bash
php artisan make:command CodeGeneratorCommand --command='code:generator'
```

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\Facades\CodeGenerator;
use VictorYoalli\LaravelCodeGenerator\Facades\CodeHelper;
use VictorYoalli\LaravelCodeGenerator\Facades\ModelLoader;

class CodeGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:generator {model : Model with namespace} {--f|force : Overwrite files if exists}';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = $this->argument('model');
        if (!$model) {
            return;
        }
        $m = ModelLoader::load($model);
        $folder = CodeHelper::plural(CodeHelper::slug($m->name));
        $force = $this->option('force');

        print "file generated: ".CodeGenerator::generate($m, 'basic/Http/Controllers/ModelController', "app/Http/Controllers/{$m->name}Controller.php", $force) . "\n";
        print "file generated: ".CodeGenerator::generate($m, 'basic/Http/Controllers/API/ModelController', "app/Http/Controllers/API/{$m->name}Controller.php", $force) . "\n";
        print "file generated: ".CodeGenerator::generate($m, 'basic/create', "resources/views/{$folder}/create.blade.php", $force) . "\n";
        print "file generated: ".CodeGenerator::generate($m, 'basic/edit', "resources/views/{$folder}/edit.blade.php", $force) . "\n";
        print "file generated: ".CodeGenerator::generate($m, 'basic/index', "resources/views/{$folder}/index.blade.php", $force) . "\n";
        print "file generated: ".CodeGenerator::generate($m, 'basic/show', "resources/views/{$folder}/show.blade.php", $force) . "\n";
    }
}

```

### Usage
```bash
php artisan code:generator 'App\Models\User' -f
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
