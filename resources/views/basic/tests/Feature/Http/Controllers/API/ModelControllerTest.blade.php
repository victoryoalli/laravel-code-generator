{!!CodeHelper::PHPSOL()!!}

namespace Tests\Feature\Http\API\Controllers;

use {{$model->complete_name}};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class {{$model->name}}ControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_stores_{{CodeHelper::snake($model->name)}}_api()
    {
        $this->withoutExceptionHandling();
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
        $this->withoutExceptionHandling();
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
        $this->withoutExceptionHandling();
        ${{CodeHelper::camel($model->name)}} = factory({{$model->name}}::class)->create();
        $response = $this->json('DELETE','api/{{CodeHelper::plural(CodeHelper::slug($model->name))}}/'.${{CodeHelper::camel($model->name)}}->id);
        $response->assertStatus(200)->assertJson(['deleted_at'=>true]);
        ${{CodeHelper::camel($model->name)}}->refresh();
        $this->assertSoftDeleted('{{CodeHelper::plural(CodeHelper::snake($model->name))}}',${{CodeHelper::camel($model->name)}}->toArray());
    }
}
