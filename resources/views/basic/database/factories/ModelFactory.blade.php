{!!CodeHelper::PHPSOL()!!}

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use {{$model->complete_name}};
use Faker\Generator as Faker;
@foreach($model->relations as $rel)
use {{$rel->model->complete_name}};
@endforeach

@php

$columns  = collect($model->table->columns);
$columns = $columns->filter(function($c){
    return ($c->name != 'id' && $c->name != 'created_at' && $c->name != 'updated_at' && $c->name != 'deleted_at');
});

function fakerType($column){
    if($column->type == 'String'){
        if(CodeHelper::contains('/password/',$column->name) ){
            $result = 'bcrypt($faker->password)';
        }
        elseif(CodeHelper::contains('/slug/',$column->name) ){
            $result = 'slug';
        }
        elseif(CodeHelper::contains('/email/',$column->name) ){
            $result = 'safeEmail';
        }
        elseif(CodeHelper::contains('/username/',$column->name) ){
            $result = 'userName';
        }
        elseif(CodeHelper::contains('/last.*name/',$column->name) ){
            $result = 'lastName';
        }
        elseif(CodeHelper::contains('/first.?name/',$column->name) ){
            $result = 'firstName';
        }
        elseif(CodeHelper::contains('/phone|mobile/',$column->name) ){
            $result = 'phoneNumber';
        }
        elseif(CodeHelper::contains('/photo/',$column->name) ){
            $result = "imageUrl(640,480,'people')";
        }
        elseif(CodeHelper::contains('/name/',$column->name) ){
            $result = 'name';
        }
        elseif(CodeHelper::contains('/img.*url|image.*url/',$column->name) ){
            $result = 'imageUrl()';
        }
        elseif(CodeHelper::contains('/image|img/',$column->name) ){
            $result = 'imageUrl()';
        }
        elseif(CodeHelper::contains('/file|path/',$column->name) ){
            $result = 'file()';
        }
        elseif(CodeHelper::contains('/url/',$column->name) ){
            $result = 'url';
        }
        elseif(CodeHelper::contains('/domain/',$column->name) ){
            $result = 'domainName';
        }
        elseif(CodeHelper::contains('/color/',$column->name) ){
            $result = 'hexcolor';
        }
        elseif(CodeHelper::contains('/token/',$column->name) ){
            $result = 'md5';
        }
        elseif($column->length > 255){
            $result = 'sentence';
        }
        else {
            $result = 'text';
        }
    }
    elseif($column->type == 'Text'){
        $result = 'text(1024)';
    }
    elseif($column->type == 'Boolean'){
        $result = 'boolean';
    }
    elseif($column->type == 'DateTime'){
        $result = 'dateTime()';
    }
    elseif($column->type == 'BigInt' && CodeHelper::contains('/_id$/',$column->name)){
        return 'factory('.CodeHelper::pascal(CodeHelper::replace('/_id$/','',$column->name)).'::class)';
    }
    elseif(CodeHelper::contains('/Int/',$column->type)){
        $result = 'randomDigit';
    }
    elseif(CodeHelper::contains('/Float|Decimal/',$column->type)){
        $result = 'randomFloat()';
    }
    else {
        $result = 'word';
    }
    if($column->nullable){
        $result = 'optional()->'.$result;

    }
    return '$faker->'.$result;
}

@endphp

$factory->define({{$model->name}}::class, function (Faker $faker) {
    return [
@foreach($columns as $column)
        '{{$column->name}}' => {!!fakerType($column)!!},
@endforeach
@foreach($model->relations as $rel)
        //{{$rel->name}} {{$rel->type}} {{$rel->model->name}} {{$rel->local_key}}
@endforeach
    ];
});
