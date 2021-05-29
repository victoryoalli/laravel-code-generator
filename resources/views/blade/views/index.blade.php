@if($options->auth)
{!!code()->tag('x-app-layout')!!}
@else
{!!code()->tag('x-guest-layout')!!}
@endif

<div class="container mx-auto">
    @@if (session('status'))
    <div class="bg-blue-100 font-medium max-w-4xl mx-auto my-4 px-8 py-4 rounded shadow text-blue-700 text-center text-sm ">
        @{{ session('status') }}
    </div>
    @@endif
    <div class="">
        <div class="">
            <h1 class="text-3xl text-blue-500 font-bold"> {{str($model->name)->human()->title()->plural()}} </h1>
        </div>
    <div class="">

    <div class="flex justify-end">
        <a class="text-blue-500" href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.create'){{code()->doubleCurlyClose()}}">New</a>
    </div>

    <div class="max-w-screen-xl mx-auto">
        <table class="w-full border-gray-200 rounded shadow overflow-hidden mx-auto">
            @@if(count(${{str($model->name)->snake()->plural()}}))
            <thead class="bg-gray-100 uppercase text-sm text-gray-500">
                <tr class="">
                    <th>&nbsp;</th>
                    @foreach($model->table->columns as $column)
                    @if(!str($column->name)->matches('/id$/')&&!str($column->name)->matches('/_at$/'))
                    <th class="px-6 py-3">{{str($column->name)->human()->title()}}</th>
                    @endif

                    @endforeach
                </tr>

            </thead>
            @@endif
            <tbody class="bg-white divide-y divide-gray-100">
                @@forelse(${{str($model->name)->snake()->plural()}} as ${{str($model->name)->snake()}})
                <tr class="">
                    <td class="px-6 py-4 text-xs">
                        <a class=" text-blue-400 hover:text-blue-500" href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.show',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake()}}] ){{code()->doubleCurlyClose()}}">Show</a>
                        <a class=" text-blue-400 hover:text-blue-500" href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.edit',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake($model->name)}}] ){{code()->doubleCurlyClose()}}">Edit</a>
                        <a class=" text-blue-400 hover:text-blue-500" href="javascript:void(0)" onclick="event.preventDefault();
                        document.getElementById('delete-{{str($model->name)->slug()}}-{{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->id{{code()->doubleCurlyClose()}}').submit();">
                            {{ __('Delete') }}
                        </a>
                        <form id="delete-{{str($model->name)->slug()}}-{{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->id{{code()->doubleCurlyClose()}}" action="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.destroy',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake()}}]){{code()->doubleCurlyClose()}}" method="POST" style="display: none;">
                            @@csrf
                            @@method('DELETE')
                        </form>
                    </td>
                    @foreach($model->table->columns as $column)
                    @if(!str($column->name)->matches('/id$/')&&!str($column->name)->matches('/_at$/'))
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">{{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->{{$column->name}}{{code()->doubleCurlyClose()}}</td>
                    @endif
                    @endforeach

                </tr>
                @@empty
                <p>No {{str($model->name)->title()->plural()}}</p>
                @@endforelse
            </tbody>
        </table>
    </div>
    </div>
    </div>

</div>
@if($options->auth)
{!!code()->tag('/x-app-layout')!!}
@else
{!!code()->tag('/x-guest-layout')!!}
@endif