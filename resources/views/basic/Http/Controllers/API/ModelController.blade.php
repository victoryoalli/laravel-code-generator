{!! code()->PHPSOL() !!}

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\{{$model->name}}Request;
use App\Http\Controllers\Controller;
@if($options->notification)
use App\Notifications\{{$model->name}}{{$options->notification}};
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

    public function show(Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        return ${{str($model->name)->snake()}};
    }

    public function store({{$model->name}}Request $request)
    {
        $data = $request->validated();
        ${{str($model->name)->snake()}} = {{$model->name}}::create($data);
@if($options->notification)
        //auth()->user->notify(new {{$model->name}}{{$options->notification}}(${{str($model->name)->snake()}}));
@endif
@if($options->event)
        event(new {{$options->event}}(${{str($model->name)->snake()}}));
@endif
        return ${{str($model->name)->snake()}};
    }

    public function update({{$model->name}}Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        $data = $request->validated();
        ${{str($model->name)->snake()}}->fill($data);
        ${{str($model->name)->snake()}}->save();

        return ${{str($model->name)->snake()}};
    }

    public function destroy(Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        ${{str($model->name)->snake()}}->delete();
        return ${{str($model->name)->snake()}};
    }

}
