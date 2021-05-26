{!!code()->PHPSOL()!!}

namespace Database\Factories;

use {{$model->complete_name}};
use Illuminate\Database\Eloquent\Factories\Factory;
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
        if(str($column->name)->match('/password/') ){
            $result = 'bcrypt($this->faker->password)';
        }
        elseif(str($column->name)->match('/slug/') ){
            $result = 'slug';
        }
        elseif(str($column->name)->match('/email/') ){
            $result = 'safeEmail';
        }
        elseif(str($column->name)->match('/username/') ){
            $result = 'userName';
        }
        elseif(str($column->name)->match('/last.*name/') ){
            $result = 'lastName';
        }
        elseif(str($column->name)->match('/first.?name/') ){
            $result = 'firstName';
        }
        elseif(str($column->name)->match('/phone|mobile/') ){
            $result = 'phoneNumber';
        }
        elseif(str($column->name)->match('/photo/') ){
            $result = "imageUrl(640,480,'people')";
        }
        elseif(str($column->name)->match('/name/') ){
            $result = 'name';
        }
        elseif(str($column->name)->match('/img.*url|image.*url/') ){
            $result = 'imageUrl()';
        }
        elseif(str($column->name)->match('/image|img/') ){
            $result = 'imageUrl()';
        }
        elseif(str($column->name)->match('/file|path/') ){
            $result = 'file()';
        }
        elseif(str($column->name)->match('/url/') ){
            $result = 'url';
        }
        elseif(str($column->name)->match('/domain/') ){
            $result = 'domainName';
        }
        elseif(str($column->name)->match('/color/') ){
            $result = 'hexcolor';
        }
        elseif(str($column->name)->match('/token/') ){
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
    return '$this->faker->'.$result;
}
@endphp

class {{$model->name}}Factory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = {{$model->name}}::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
    @foreach($columns as $column)
            '{{$column->name}}' => {!!fakerType($column)!!},
    @endforeach
    @foreach($model->relations as $rel)
            //{{$rel->name}} {{$rel->type}} {{$rel->model->name}} {{$rel->local_key}}
    @endforeach
        ];

    }
}