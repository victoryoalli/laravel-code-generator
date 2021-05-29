{!!code()->PHPSOL()!!}

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
    public function it_stores_{{str($model->name)->snake()}}_api()
    {
@if($options->auth)
        Passport::actingAs(User::factory()->create(), ['api/{{str($model->name)->plural()->slug()}}']);
@endif
        ${{str($model->name)->camel()}} = {{$model->name}}::factory()->make();
        $data = ${{str($model->name)->camel()}}->attributesToArray();
        $response = $this->json('POST','api/{{str($model->name)->plural()->slug()}}',$data);
        $response->assertStatus(201)->assertJson(['created_at'=>true]);
    }

    /**
     * @test
     */
    public function it_updates_{{str($model->name)->snake()}}_api()
    {
@if($options->auth)
        Passport::actingAs(User::factory()->create(), ['api/{{str($model->name)->plural()->slug()}}']);
@endif
        ${{str($model->name)->camel()}} = {{$model->name}}::factory()->create();
        $data = {{$model->name}}::factory()->make()->attributesToArray();
        $response = $this->json('PUT','api/{{str($model->name)->plural()->slug()}}/'.${{str($model->name)->camel()}}->id,$data);
        $response->assertStatus(200)->assertJson(['updated_at'=>true]);
    }

    /**
     * @test
     */
    public function it_destroys_{{str($model->name)->snake()}}_api()
    {
@if($options->auth)
        Passport::actingAs(User::factory()->create(), ['api/{{str($model->name)->plural()->slug()}}']);
@endif
        ${{str($model->name)->camel()}} = {{$model->name}}::factory()->create();
        $response = $this->json('DELETE','api/{{str($model->name)->plural()->slug()}}/'.${{str($model->name)->camel()}}->id);
        $response->assertStatus(200)->assertJson(['deleted_at'=>true]);
        ${{str($model->name)->camel()}}->refresh();
@if(collect($model->table->columns)->contains('name','deleted_at'))
        $this->assertSoftDeleted('{{str($model->name)->plural()->snake()}}',['id' => ${{str($model->name)->camel()}}->id]);
@else
        $this->assertDatabaseMissing('{{str($model->name)->plural()->snake()}}',['id' => ${{str($model->name)->camel()}}->id]);
@endif

    }
}
