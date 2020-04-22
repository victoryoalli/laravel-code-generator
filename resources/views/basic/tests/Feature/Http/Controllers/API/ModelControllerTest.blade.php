{!!CodeHelper::PHPSOL()!!}

namespace Tests\Feature\Http\API\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use {{$model->complete_name}};
use {{$model->namespace}}\User;
@if($options->auth)
use Laravel\Passport\Passport;
@endif

class {{$model->name}}ControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_stores_{{CodeHelper::snake($model->name)}}_api()
    {
@if($options->auth)
        Passport::actingAs(factory(User::class)->create(), ['api/{{CodeHelper::plural(CodeHelper::slug($model->name))}}']);
@endif
        ${{CodeHelper::camel($model->name)}} = factory({{$model->name}}::class)->make();
        $data = ${{CodeHelper::camel($model->name)}}->attributesToArray();
        $response = $this->json('POST','api/{{CodeHelper::plural(CodeHelper::slug($model->name))}}',$data);
        $response->assertStatus(201)->assertJson(['created_at'=>true]);
    }

    /**
     * @test
     */
    public function it_updates_{{CodeHelper::snake($model->name)}}_api()
    {
@if($options->auth)
        Passport::actingAs(factory(User::class)->create(), ['api/{{CodeHelper::plural(CodeHelper::slug($model->name))}}']);
@endif
        ${{CodeHelper::camel($model->name)}} = factory({{$model->name}}::class)->create();
        $data = factory({{$model->name}}::class)->make()->attributesToArray();
        $response = $this->json('PUT','api/{{CodeHelper::plural(CodeHelper::slug($model->name))}}/'.${{CodeHelper::camel($model->name)}}->id,$data);
        $response->assertStatus(200)->assertJson(['updated_at'=>true]);
    }

    /**
     * @test
     */
    public function it_destroys_{{CodeHelper::snake($model->name)}}_api()
    {
@if($options->auth)
        Passport::actingAs(factory(User::class)->create(), ['api/{{CodeHelper::plural(CodeHelper::slug($model->name))}}']);
@endif
        ${{CodeHelper::camel($model->name)}} = factory({{$model->name}}::class)->create();
        $response = $this->json('DELETE','api/{{CodeHelper::plural(CodeHelper::slug($model->name))}}/'.${{CodeHelper::camel($model->name)}}->id);
        $response->assertStatus(200)->assertJson(['deleted_at'=>true]);
        ${{CodeHelper::camel($model->name)}}->refresh();
@if(collect($model->table->columns)->contains('name','deleted_at'))
        $this->assertSoftDeleted('{{CodeHelper::plural(CodeHelper::snake($model->name))}}',['id' => ${{CodeHelper::camel($model->name)}}->id]);
@else
        $this->assertDatabaseMissing('{{CodeHelper::plural(CodeHelper::snake($model->name))}}',['id' => ${{CodeHelper::camel($model->name)}}->id]);
@endif

    }
}
