{!! CodeHelper::PHPSOL() !!}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{{$model->name}}PostRequest;
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
        ${{CodeHelper::snake(CodeHelper::plural($model->name))}} = {{$model->name}}::all();
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index', compact('{{CodeHelper::snake(CodeHelper::plural($model->name))}}'));
    }

    public function show(Request $request, {{$model->name}} ${{CodeHelper::snake($model->name)}})
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.show', compact('{{CodeHelper::snake($model->name)}}'));
    }

    public function create()
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.create');
    }

    public function store({{$model->name}}PostRequest $request)
    {
        $data = $request->validated();
        ${{CodeHelper::snake($model->name)}} = {{$model->name}}::create($data);
@if($options->notification)
        //auth()->user->notify(new {{$model->name}}Notification(${{CodeHelper::snake($model->name)}}));
@endif
@if($options->event)
        event(new New{{$model->name}}(${{CodeHelper::snake($model->name)}}));
@endif
        return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index')->with('status', '{{$model->name}} created!');
    }

    public function edit(Request $request, {{$model->name}} ${{CodeHelper::snake($model->name)}})
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.edit', compact('{{CodeHelper::snake($model->name)}}'));
    }

    public function update({{$model->name}}PostRequest $request, {{$model->name}} ${{CodeHelper::snake($model->name)}})
    {
        $data = $request->validated();
        ${{CodeHelper::snake($model->name)}}->fill($data);
        ${{CodeHelper::snake($model->name)}}->save();
        return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index')->with('status', '{{$model->name}} updated!');
    }

    public function destroy(Request $request, {{$model->name}} ${{CodeHelper::snake($model->name)}})
    {
        ${{CodeHelper::snake($model->name)}}->delete();
        return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index')->with('status', '{{$model->name}} destroyed!');
    }
}
