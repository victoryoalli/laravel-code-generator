@if($options->auth)
{!!code()->tag('x-app-layout')!!}
@else
{!!code()->tag('x-guest-layout')!!}
@endif

<div class="container mx-auto">
    @@if (session('status'))
    <div class="fixed z-20 inset-x-0" x-data="{show:true}" x-show="show" x-cloak>
        <div class="bg-gradient-to-r font-medium font-semibold from-green-500 max-w-4xl mx-auto my-4 px-8 py-4 rounded shadow text-center text-green-50 to-green-600" @click.away="show=false">
            @{{ session('status') }}
        </div>
    </div>
    @@endif
    <div class="py-8">
        <div class=" mx-auto">
            <h1 class="text-3xl text-blue-500 font-bold"> {{str($model->name)->human()->title()->plural()}} </h1>
            {!!code()->tag('x-slot name="header"')!!} {{str($model->name)->human()->plural()->title()}} {!! code()->tag('/x-slot') !!}
        </div>
        <div class=" mx-auto flex justify-end my-8">
            <a class="text-blue-50 bg-blue-500 px-5 py-1.5 rounded hover:bg-blue-700" href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.create'){{code()->doubleCurlyClose()}}">Create {{str($model->name)->human()->title()}}</a>
        </div>

        <div class=" mx-auto">
            <table class="w-full border-gray-200 rounded shadow overflow-hidden mx-auto">
                @@if(count(${{str($model->name)->snake()->plural()}}))
                <thead class="bg-gray-200 uppercase text-sm text-gray-500">
                    <tr class="">
                        <th>&nbsp;</th>
                        @foreach($model->table->columns as $column)
                        @if(!str($column->name)->matches('/id$/')&&!str($column->name)->matches('/_at$/'))
                        <th class="px-6 py-3 whitespace-nowrap">{{str($column->name)->human()->title()}}</th>
                        @endif
                        @endforeach
                    </tr>
                </thead>
                @@endif
                <tbody class="bg-white divide-y divide-gray-100">
                    @@forelse(${{str($model->name)->snake()->plural()}} as ${{str($model->name)->snake()}})
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-xs">
                            <div class="flex items-center space-x-1">
                                <a class=" text-blue-400 hover:text-blue-500" href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.show',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake()}}] ){{code()->doubleCurlyClose()}}">Show</a>
                                <a class=" text-blue-400 hover:text-blue-500" href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.edit',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake($model->name)}}] ){{code()->doubleCurlyClose()}}">Edit</a>
                                <a class=" text-blue-400 hover:text-blue-500" href="javascript:void(0)" onclick="event.preventDefault();
                            document.getElementById('delete-{{str($model->name)->slug()}}-{{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->id{{code()->doubleCurlyClose()}}').submit();">
                                    {{ __('Delete') }}
                                </a>
                            </div>
                            <form id="delete-{{str($model->name)->slug()}}-{{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->id{{code()->doubleCurlyClose()}}" action="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.destroy',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake()}}]){{code()->doubleCurlyClose()}}" method="POST" style="display: none;">
                                @@csrf
                                @@method('DELETE')
                            </form>
                        </td>
                        @foreach($model->table->columns as $column)
                        @if(!str($column->name)->matches('/id$/')&&!str($column->name)->matches('/_at$/'))
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600 truncate max-w-xs">{{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->{{$column->name}}{{code()->doubleCurlyClose()}}</td>
                        @endif
                        @endforeach

                    </tr>
                    @@empty
                    <p>No {{str($model->name)->title()->plural()}}</p>
                    @@endforelse
                </tbody>
            </table>
        </div>
        <div class=" mx-auto my-8">
            {{code()->doubleCurlyOpen()}} ${{str($model->name)->plural->snake()}}->links() {{code()->doubleCurlyClose()}}
        </div>
    </div>

</div>
@if($options->auth)
{!!code()->tag('/x-app-layout')!!}
@else
{!!code()->tag('/x-guest-layout')!!}
@endif