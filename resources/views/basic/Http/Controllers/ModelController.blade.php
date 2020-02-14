{!! CodeHelper::PHPSOL() !!}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use {{$model->complete_name}};


class {{$model->name}}Controller
{
    public function index()
    {
        ${{CodeHelper::camel(CodeHelper::plural($model->name))}} = {{$model->name}}::all();
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index', compact('{{CodeHelper::camel(CodeHelper::plural($model->name))}}'));
    }

    public function show(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.show', compact('{{CodeHelper::camel($model->name)}}'));
    }

    public function create()
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
        @foreach($model->table->columns as $col)
        @if(!CodeHelper::contains('/id$/',$col->name) && !CodeHelper::contains('/_at$/',$col->name))

        '{{$col->name}}' => [
        @if(!$col->nullable)
            'required',
        @endif
        ],
        @endif
        @endforeach

        ]);
        if ($validator->fails()) {
            return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.create')
                        ->withErrors($validator)
                        ->withInput();
        }
        {{$model->name}}::create($data);
        return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index')->with('status', '{{$model->name}} created!');
    }

    public function edit(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.edit', compact('{{CodeHelper::camel($model->name)}}'));
    }

    public function update(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        $data = $request->all();
        $validator = Validator::make($data, [
        @foreach($model->table->columns as $col)
        @if(!CodeHelper::contains('/id$/',$col->name) && !CodeHelper::contains('/_at$/',$col->name))

        '{{$col->name}}' => [
        @if(!$col->nullable)
            'required',
        @endif
        ],
        @endif
        @endforeach
        ]);

        if ($validator->fails()) {
            return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.edit', ['{{CodeHelper::camel($model->name)}}' => ${{CodeHelper::camel($model->name)}}])
                        ->withErrors($validator)
                        ->withInput();
        }

        ${{CodeHelper::camel($model->name)}}->fill($data);
        ${{CodeHelper::camel($model->name)}}->save();
        return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index')->with('status', '{{$model->name}} updated!');
    }

    public function destroy(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        ${{CodeHelper::camel($model->name)}}->delete();
        return redirect()->route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index')->with('status', '{{$model->name}} destroyed!');
    }
}
