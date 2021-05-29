{!! code()->PHPSOL() !!}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{{$model->name}}Request;
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
        $this->middleware('auth');
    }
@endif

    public function index()
    {
        ${{str($model->name)->snake()->plural()}} = {{$model->name}}::paginate(10);
        return view('{{str($model->name)->snake()->plural()}}.index', compact('{{str($model->name)->snake()->plural()}}'));
    }

    public function show(Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        return view('{{str($model->name)->snake()->plural()}}.show', compact('{{str($model->name)->snake()}}'));
    }

    public function create()
    {
        return view('{{str($model->name)->snake()->plural()}}.create');
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
        return redirect()->route('{{str($model->name)->slug()->plural()}}.index')->with('status', '{{$model->name}} created!');
    }

    public function edit(Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        return view('{{str($model->name)->snake()->plural()}}.edit', compact('{{str($model->name)->snake()}}'));
    }

    public function update({{$model->name}}Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        $data = $request->validated();
        ${{str($model->name)->snake()}}->fill($data);
        ${{str($model->name)->snake()}}->save();
        return redirect()->route('{{str($model->name)->slug()->plural()}}.index')->with('status', '{{$model->name}} updated!');
    }

    public function destroy(Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        ${{str($model->name)->snake()}}->delete();
        return redirect()->route('{{str($model->name)->slug()->plural()}}.index')->with('status', '{{$model->name}} destroyed!');
    }
}
