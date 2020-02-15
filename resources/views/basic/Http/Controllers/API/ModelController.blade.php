{!! CodeHelper::PHPSOL() !!}

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\{{$model->name}}PostRequest;
use App\Http\Controllers\Controller;
@if($options->notification)
use App\Notifications\{{$model->name}}Notification;
@endif
@if($options->event)
use App\Events\New{{$model->name}};
@endif
use {{$model->complete_name}};

class {{$model->name}}Controller extends Controller
{
@if($options->auth)
    public function __construct()
    {
        //parent::__construct();
        $this->middleware('auth');
    }
@endif


    public function index()
    {
        ${{CodeHelper::camel(CodeHelper::plural($model->name))}} = {{$model->name}}::all();
        return ${{CodeHelper::camel(CodeHelper::plural($model->name))}};
    }

    public function show(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        return ${{CodeHelper::camel($model->name)}};
    }

    public function store({{$model->name}}PostRequest $request)
    {
        $data = $request->validated();
        ${{CodeHelper::camel($model->name)}} = {{$model->name}}::create($data);
@if($options->notification)
        //auth()->user->notify(new {{$model->name}}Notification(${{CodeHelper::camel($model->name)}}));
@endif
@if($options->event)
        event(new New{{$model->name}}(${{CodeHelper::camel($model->name)}}));
@endif
        return ${{CodeHelper::camel($model->name)}};
    }

    public function update({{$model->name}}PostRequest $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        $data = $request->validated();
        ${{CodeHelper::camel($model->name)}}->fill($data);
        ${{CodeHelper::camel($model->name)}}->save();

        return ${{CodeHelper::camel($model->name)}};
    }

    public function destroy(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        ${{CodeHelper::camel($model->name)}}->delete();
        return ${{CodeHelper::camel($model->name)}};
    }

}
