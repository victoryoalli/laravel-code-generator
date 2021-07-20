{!! code()->PHPSOL() !!}

namespace App\Http\Controllers;

use {{$model->complete_name}};
use Illuminate\Http\Request;
use App\Http\Requests\{{$model->name}}Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
@if($options->notification)
use App\Notifications\{{$model->name}}{{$options->notification}};
@endif
@if($options->event)
use App\Events\{{$options->event}};
@endif

class {{$model->name}}Controller extends Controller
{
@if($options->auth)
    public function __construct()
    {
        $this->middleware('auth');
    }
@endif

    public function index()
    {
        return Inertia::render('{{str($model->name)->plural()}}/Index', ['{{str($model->name)->snake()->plural()}}'=>{{$model->name}}::paginate(25)]);
    }

    public function create()
    {
        return Inertia::render('{{str($model->name)->plural()}}/Create');
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

        return Redirect::route('{{str($model->name)->snake()->slug()->plural()}}.index')->with('status', '{{str($model->name)->human()}} created!');
    }

    public function edit(Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
@php
        $rels = collect($model->relations)->filter(function($rel){ return $rel->type === 'HasMany'; });
        $rels_names = $rels->pluck('name');
        $relations = $rels->map(function($rel){ return "'".$rel->name."' => $".$rel->name; })->implode(', ');
@endphp
@foreach($rels_names as $name)
        ${{$name}} = {{$model->name}}::find(${{str($model->name)->snake()}}->id)->{{$name}}()->paginate(25);
@endforeach

        return Inertia::render('{{str($model->name)->plural()}}/Edit', ['{{str($model->name)->snake()}}'=>${{str($model->name)->snake()}}, {!!$relations!!}]);
    }

    public function update({{$model->name}}Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        $data = $request->validated();
        ${{str($model->name)->snake()}}->fill($data);
        ${{str($model->name)->snake()}}->save();

        return Redirect::route('{{str($model->name)->snake()->slug()->plural()}}.index')->with('status', '{{str($model->name)->human()}} updated!');
    }

    public function destroy(Request $request, {{$model->name}} ${{str($model->name)->snake()}})
    {
        ${{str($model->name)->snake()}}->delete();

        return Redirect::route('{{str($model->name)->snake()->slug()->plural()}}.index')->with('status', '{{str($model->name)->human()}} deleted!');
    }
}
