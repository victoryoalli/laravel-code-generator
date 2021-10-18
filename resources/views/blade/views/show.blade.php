@if($options->auth)
{!!code()->tag('x-app-layout')!!}
@else
{!!code()->tag('x-guest-layout')!!}
@endif

<div class="container mx-auto py-8">
    <div class="grid md:grid-cols-3">
        <div class="mb-4 mx-4">
            <h1 class="mb-4 text-blue-500 text-3xl font-bold"> {{str($model->name)->human()->title()}}</h1>
            @@if ($errors->any())
            <ul class="list-disc list-inside text-sm text-red-500">
                @@foreach ($errors->all() as $error)
                <li class="">@{{ $error }}</li>
                @@endforeach
            </ul>
            @@endif
        </div>
        <div class="col-span-2 bg-white shadow rounded-lg overflow-auto">
            <form action="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.update',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake()}}->id]){{code()->doubleCurlyClose()}}" method="POST" novalidate>
                <div class="space-y-3 p-4">
@foreach($model->relations as $rel)
@if($rel->type === 'BelongsTo')
                    <div class="{{$rel->type}}">
                        <label class="block text-sm font-semibold text-gray-700" for="{{$rel->local_key}}">{{str($rel->name)->title()}}</label>
                        @@foreach((\{{$rel->model->complete_name}}::all() ?? [] ) as ${{$rel->name}})
                        @@if(${{str($model->name)->snake()}}->{{$rel->local_key}} == ${{$rel->name}}->id)
                        <a href="{{code()->doubleCurlyOpen()}}route('{{str($rel->name)->plural()->slug()}}.show',['{{str($rel->name)->slug()}}'=>${{str($rel->name)->snake()}}->id]){{code()->doubleCurlyClose()}}" class="px-3 py-1.5 mt-1 block w-full text-blue-500 hover:text-blue-700 hover:underline sm:text-sm border-transparent focus:ring-transparent focus:outline-none focus:border-transparent rounded">
                            {{code()->doubleCurlyOpen()}}${{$rel->name}}->{{collect($rel->model->table->columns)->filter(fn($col,$key) => ($col->type == 'String') )->map(function($col){ return $col->name;})->first()}}{{code()->doubleCurlyClose()}}
                        </a>
                        @@endif
                        @@endforeach

                    </div>
@endif
@endforeach

@foreach($model->table->columns as $column)
@if(!str($column->name)->matches('/id$/') && !str($column->name)->matches('/created_at$/') && !str($column->name)->matches('/updated_at$/') && !str($column->name)->matches('/deleted_at$/'))
                    <div class="">
                        <label class="block text-sm font-semibold text-gray-700" for="{{$column->name}}">{{str($column->name)->title()}}</label>
                        @if(str($column->type)->matches('/Text/'))
                        <textarea readonly name="{{$column->name}}" class="mt-1 focus:outline-none focus:ring-transparent focus:border-transparent block w-full  sm:text-sm border-transparent {{$column->type}}">{{code()->doubleCurlyOpen()}}old('{{$column->name}}',${{str($model->name)->snake()}}->{{$column->name}}){{code()->doubleCurlyClose()}}</textarea>
@else
                        <input readonly name="{{$column->name}}" @if($column->type == 'String')
                        type="text"
                        maxlength="{{$column->length}}"
                        @elseif(str($column->type)->matches('/Date/'))
                        type="date"
                        @elseif(str($column->type)->matches('/Int/'))
                        type="number"
                        @elseif(str($column->type)->matches('/Decimal|Float/'))
                        type="number"
                        step="0.01"
                        @endif
                        class="mt-1 block w-full sm:text-sm border-transparent focus:ring-transparent focus:outline-none focus:border-transparent rounded {{$column->type}}"
                        @if(!$column->nullable)
                        required="required"
                        @endif
                        value="{{code()->doubleCurlyOpen()}}old('{{$column->name}}',${{str($model->name)->snake()}}->{{$column->name}}){{code()->doubleCurlyClose()}}"
                        >
@endif
                        @@if($errors->has('{{$column->name}}'))
                        <p class="mt-0.5 text-sm text-red-500">{{code()->doubleCurlyOpen()}}$errors->first('{{$column->name}}'){{code()->doubleCurlyClose()}}</p>
@@endif
                    </div>
@endif
@endforeach
                </div>
                <div class="bg-gray-100 flex items-center justify-between px-4 py-5 space-x-3">
                    <a class="text-blue-500" href="@{{ url()->previous() }}">Back</a>
                    <a href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->plural()->slug()}}.edit',${{str($model->name)->snake()}}){{code()->doubleCurlyClose()}}" class="px-6 py-1.5 border-lg bg-blue-500 text-blue-50 font-semibold rounded hover:bg-blue-700">Edit {{str($model->name)->human()->title()}} </a>
                </div>
            </form>
        </div>
        </div>
        <!-- Relations -->
        <div class="container mx-auto mt-24">
            @foreach($model->relations as $rel)
            @if($rel->type === 'HasMany')
                <h2 class="my-8 text-2xl text-blue-500 font-bold">{{str($rel->name)->human()->title()}} <span class="text-blue-300 text-base">({{code()->doubleCurlyOpen()}}${{str($model->name)->camel()}}->{{str($rel->model->name)->snake()->plural()}}->count(){{code()->doubleCurlyClose()}})</span></h2>
                <table class="w-full border-gray-200 rounded shadow overflow-hidden mx-auto">
                    <thead class="bg-gray-200 uppercase text-xm text-gray-500">
                        <tr>
                            <th>&nbsp;</th>
                            @foreach($rel->model->table->columns as $column)
                            @if($column->type === 'String' || $column->type === 'Text')
                            <th class="px-6 py-3 whitespace-nowrap"> {{str($column->name)->human()->title()}}</th>
                            @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @@foreach(${{str($model->name)->camel()}}->{{str($rel->name)->snake()}} as ${{str($rel->name)->singular()}})
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-xs">
                                <div class="flex items-center space-x-1">
                                    <a class=" text-blue-400 hover:text-blue-500" href="{{code()->doubleCurlyOpen()}}route('{{str($rel->model->name)->slug()->plural()}}.show',['{{str($rel->model->name)->camel()}}'=>${{str($rel->model->name)->camel()}}] ){{code()->doubleCurlyClose()}}">Show</a>
                                    <a class=" text-blue-400 hover:text-blue-500" href="{{code()->doubleCurlyOpen()}}route('{{str($rel->model->name)->slug()->plural()}}.edit',['{{str($rel->model->name)->camel()}}'=>${{str($rel->model->name)->camel()}}] ){{code()->doubleCurlyClose()}}">Edit</a>
                                    <a class=" text-blue-400 hover:text-blue-500" href="javascript:void(0)" onclick="event.preventDefault();
                            document.getElementById('delete-{{str($rel->model->name)->slug()}}-{{code()->doubleCurlyOpen()}}${{str($rel->model->name)->camel()}}->id{{code()->doubleCurlyClose()}}').submit();">
                                        {{ __('Delete') }}
                                    </a>
                                </div>
                                <form id="delete-{{str($rel->model->name)->slug()}}-{{code()->doubleCurlyOpen()}}${{str($rel->model->name)->camel()}}->id{{code()->doubleCurlyClose()}}" action="{{code()->doubleCurlyOpen()}}route('{{str($rel->model->name)->slug()->plural()}}.destroy',['{{str($rel->model->name)->camel()}}'=>${{str($rel->model->name)->camel()}}]){{code()->doubleCurlyClose()}}" method="POST" style="display: none;">
                                    @@csrf
                                    @@method('DELETE')
                                </form>
                            </td>
                            @foreach($rel->model->table->columns as $column)
                            @if($column->type === 'String' || $column->type === 'Text')
                            <td class="px-6 py-4 whitespace-nowrap text-xm font-medium text-gray-600 truncate max-w-xs"> {{code()->doubleCurlyOpen()}} ${{str($rel->model->name)->camel()}}->{{$column->name}}{{code()->doubleCurlyClose()}}</td>
                            @endif
                            @endforeach
                        </tr>

                        @@endforeach
                    </tbody>
                </table>
            @endif
            @endforeach
    </div>
        <!-- //Relations -->
    @if($options->auth)
    {!!code()->tag('/x-app-layout')!!}
    @else
    {!!code()->tag('/x-guest-layout')!!}
    @endif