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
        if(str($column->name)->matches('/password/') ){
            $result = 'bcrypt($this->faker->password)';
        }
        elseif(str($column->name)->matches('/slug/') ){
            $result = 'slug()';
        }
        elseif(str($column->name)->matches('/email/') ){
            $result = 'safeEmail()';
        }
        elseif(str($column->name)->matches('/username/') ){
            $result = 'userName()';
        }
        elseif(str($column->name)->matches('/last.*name/') ){
            $result = 'lastName()';
        }
        elseif(str($column->name)->matches('/first.?name/') ){
            $result = 'firstName()';
        }
        elseif(str($column->name)->matches('/phone|mobile/') ){
            $result = 'phoneNumber()';
        }
        elseif(str($column->name)->matches('/photo/') ){
            $result = "imageUrl(640,480,'people')";
        }
        elseif(str($column->name)->matches('/name/') ){
            $result = 'name()';
        }
        elseif(str($column->name)->matches('/img.*url|image.*url/') ){
            $result = 'imageUrl()';
        }
        elseif(str($column->name)->matches('/image|img/') ){
            $result = 'imageUrl()';
        }
        elseif(str($column->name)->matches('/file|path/') ){
            $result = 'file()';
        }
        elseif(str($column->name)->matches('/url/') ){
            $result = 'url';
        }
        elseif(str($column->name)->matches('/domain/') ){
            $result = 'domainName';
        }
        elseif(str($column->name)->matches('/color/') ){
            $result = 'hexcolor';
        }
        elseif(str($column->name)->matches('/token/') ){
            $result = 'md5';
        }
        elseif($column->length > 255){
            $result = 'sentence';
        }
        else {
            $result = 'text()';
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
    elseif($column->type == 'BigInt' && str($column->name)->matches('/_id$/')){
        return str($column->name)->replace('_id','')->camel()->ucfirst().'::factory()->create()->id';
    }
    elseif(str($column->type)->matches('/Int/')){
        $result = 'randomDigit';
    }
    elseif(str($column->type)->matches('/Float|Decimal/')){
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