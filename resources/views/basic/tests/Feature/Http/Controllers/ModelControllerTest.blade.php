{!!CodeHelper::PHPSOL()!!}

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
    public function it_stores_{{CodeHelper::snake($model->name)}}_and_redirects()
    {
@if($options->auth)
        $user = factory(User::class)->create();
        $response = $this->actingAs($user);
@endif

        ${{CodeHelper::camel($model->name)}} = factory({{$model->name}}::class)->make();
        $data = ${{CodeHelper::camel($model->name)}}->attributesToArray();
        $response = $this->post(route('{{CodeHelper::plural(CodeHelper::slug($model->name))}}.store'), $data);
        $response->assertRedirect(route('{{CodeHelper::plural(CodeHelper::slug($model->name))}}.index'));
        $response->assertSessionHas('status', '{{$model->name}} created!');
    }

    /**
     * @test
     */
    public function it_updates_{{CodeHelper::snake($model->name)}}_and_redirects()
    {
@if($options->auth)
        $user = factory(User::class)->create();
        $response = $this->actingAs($user);
@endif
        ${{CodeHelper::camel($model->name)}} = factory({{$model->name}}::class)->create();
        $data = factory({{$model->name}}::class)->make()->attributesToArray();
        $response = $this->put(route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.update', ['{{CodeHelper::snake($model->name)}}' => ${{CodeHelper::camel($model->name)}}]), $data);
        $response->assertRedirect(route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index'));
        $response->assertSessionHas('status', '{{$model->name}} updated!');
    }

    /**
     * @test
     */
    public function it_destroys_{{CodeHelper::snake($model->name)}}_and_redirects()
    {
@if($options->auth)
        $user = factory(User::class)->create();
        $response = $this->actingAs($user);
@endif
        ${{CodeHelper::camel($model->name)}} = factory({{$model->name}}::class)->create();
        $response = $this->delete(route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.destroy', ['{{CodeHelper::snake($model->name)}}' => ${{CodeHelper::camel($model->name)}}]));
        $response->assertRedirect(route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index'));
        $response->assertSessionHas('status', '{{$model->name}} destroyed!');
    }
}
