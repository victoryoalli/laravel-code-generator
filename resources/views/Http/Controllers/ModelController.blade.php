{!!CodeHelper::PHPSOL()!!}

namespace App\Http\Controllers;

use App\Models\{{$model->name}};
use Illuminate\Http\Request;

class {{$model->name}}Controller extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
    * Display the specified resource.
    *
    * @param \App\Models\{{$model->name}} ${{CodeHelper::camel($model->name)}}
    * @return \Illuminate\Http\Response
    */
    public function show({{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.show');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param \App\Models\{{$model->name}} ${{CodeHelper::camel($model->name)}}
    * @return \Illuminate\Http\Response
    */
    public function edit({{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        return view('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.edit');
    }

    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param \App\Models\{{$model->name}} ${{CodeHelper::camel($model->name)}}
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, {{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        return {{$model->name}}::update($request->all());
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param \App\Models\{{$model->name}} ${{CodeHelper::camel($model->name)}}
    * @return \Illuminate\Http\Response
    */
    public function destroy({{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        abort(404);
    }
}