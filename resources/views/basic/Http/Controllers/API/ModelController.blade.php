{!! CodeHelper::PHPSOL() !!}

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\{{$model->name}}PostRequest;
use App\Http\Controllers\Controller;
@if($options->notification)
use App\Notifications\{{$options->notification}};
@endif
@if($options->event)
use App\Events\{{$options->event}};
@endif
use {{$model->complete_name}};

class {{$model->name}}Controller extends Controller
{
@if($options->auth)
    public function __construct()
    {
        //parent::__construct();
        $this->middleware('auth:api');
    }
@endif


    public function index()
    {
        return {{$model->name}}::all();
    }

    public function show(Request $request, {{$model->name}} ${{CodeHelper::snake($model->name)}})
    {
        return ${{CodeHelper::snake($model->name)}};
    }

    public function store({{$model->name}}PostRequest $request)
    {
        $data = $request->validated();
        ${{CodeHelper::snake($model->name)}} = {{$model->name}}::create($data);
@if($options->notification)
        //auth()->user->notify(new {{$options->notification}}(${{CodeHelper::snake($model->name)}}));
@endif
@if($options->event)
        event(new {{$options->event}}(${{CodeHelper::snake($model->name)}}));
@endif
        return ${{CodeHelper::snake($model->name)}};
    }

    public function update({{$model->name}}PostRequest $request, {{$model->name}} ${{CodeHelper::snake($model->name)}})
    {
        $data = $request->validated();
        ${{CodeHelper::snake($model->name)}}->fill($data);
        ${{CodeHelper::snake($model->name)}}->save();

        return ${{CodeHelper::snake($model->name)}};
    }

    public function destroy(Request $request, {{$model->name}} ${{CodeHelper::snake($model->name)}})
    {
        ${{CodeHelper::snake($model->name)}}->delete();
        return ${{CodeHelper::snake($model->name)}};
    }

}
