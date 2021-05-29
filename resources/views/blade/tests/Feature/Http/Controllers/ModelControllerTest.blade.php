{!!code()->PHPSOL()!!}

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use {{$model->complete_name}};
@if($options->auth)
use {{$model->namespace}}\User;
@endif

class {{$model->name}}ControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_stores_{{str($model->name)->snake()}}_and_redirects_web()
    {
@if($options->auth)
        $user = User::factory()->create();
        $response = $this->actingAs($user);
@endif

        ${{str($model->name)->camel()}} = {{$model->name}}::factory()->make();
        $data = ${{str($model->name)->camel()}}->attributesToArray();
        $response = $this->post(route('{{str($model->name)->plural()->slug()}}.store'), $data);
        $response->assertRedirect(route('{{str($model->name)->plural()->slug()}}.index'));
        $response->assertSessionHas('status', '{{$model->name}} created!');
    }

    /**
     * @test
     */
    public function it_updates_{{str($model->name)->snake()}}_and_redirects_web()
    {
@if($options->auth)
        $user = User::factory()->create();
        $response = $this->actingAs($user);
@endif
        ${{str($model->name)->camel()}} = {{$model->name}}::factory()->create();
        $data = {{$model->name}}::factory()->make()->attributesToArray();
        $response = $this->put(route('{{str($model->name)->slug()->plural()}}.update', ['{{str($model->name)->snake()}}' => ${{str($model->name)->camel()}}]), $data);
        $response->assertRedirect(route('{{str($model->name)->slug()->plural()}}.index'));
        $response->assertSessionHas('status', '{{$model->name}} updated!');
    }

    /**
     * @test
     */
    public function it_destroys_{{str($model->name)->snake()}}_and_redirects_web()
    {
@if($options->auth)
        $user = User::factory()->create();
        $response = $this->actingAs($user);
@endif
        ${{str($model->name)->camel()}} = {{$model->name}}::factory()->create();
        $response = $this->delete(route('{{str($model->name)->slug()->plural()}}.destroy', ['{{str($model->name)->snake()}}' => ${{str($model->name)->camel()}}]));
        $response->assertRedirect(route('{{str($model->name)->slug()->plural()}}.index'));
        $response->assertSessionHas('status', '{{$model->name}} destroyed!');
    }
}
