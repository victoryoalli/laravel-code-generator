{!! CodeHelper::PHPSOL() !!}

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use {{$model->complete_name}};

class {{$model->name}}Controller
{
    public function index()
    {
        ${{CodeHelper::camel(CodeHelper::plural($model->name))}} = {{$model->name}}::all();
        return ${{CodeHelper::camel(CodeHelper::plural($model->name))}};
    }

    public function show(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        return ${{CodeHelper::camel($model->name)}};
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
        ${{CodeHelper::camel($model->name)}} = {{$model->name}}::create($data);

       return ${{CodeHelper::camel($model->name)}};
    }

    public function update(Request $request, Setting $setting)
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

        return ${{CodeHelper::camel($model->name)}};
    }

    public function destroy(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        ${{CodeHelper::camel($model->name)}}->delete();
        return ${{CodeHelper::camel($model->name)}};
    }

}
