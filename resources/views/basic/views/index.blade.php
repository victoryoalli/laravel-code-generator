@if($options->auth)
{!!code()->tag('x-app-layout')!!}
@else
{!!code()->tag('x-guest-layout')!!}
@endif

<div class="">
    @@if (session('status'))
    <div class="">
        @{{ session('status') }}
    </div>
    @@endif
    <div class="">
        <div class="">
            <h1> {{str($model->name)->human()->title()->plural()}} </h1>
        </div>
    <div class="">

    <div>
        <a href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.create'){{code()->doubleCurlyClose()}}">New</a>
    </div>
    <table class="">
        @@if(count(${{str($model->name)->snake()->plural()}}))
        <thead>
            <tr>
                <th>&nbsp;</th>
                @foreach($model->table->columns as $column)
                @if(!str($column->name)->matches('/id$/')&&!str($column->name)->matches('/_at$/'))
                <td>{{str($column->name)->human()->title()}}</td>
                @endif

                @endforeach
            </tr>

        </thead>
        @@endif
        <tbody>
            @@forelse(${{str($model->name)->snake()->plural()}} as ${{str($model->name)->snake()}})
            <tr>
                <td>
                    <a href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.show',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake()}}] ){{code()->doubleCurlyClose()}}">Show</a>
                    <a href="{{code()->doubleCurlyOpen()}}route('{{str($model->name)->slug()->plural()}}.edit',['{{str($model->name)->snake()}}'=>${{str($model->name)->snake($model->name)}}] ){{code()->doubleCurlyClose()}}">Edit</a>
                    <a href="javascript:void(0)" onclick="event.preventDefault();
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
                <td>{{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->{{$column->name}}{{code()->doubleCurlyClose()}}</td>
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
@if($options->auth)
{!!code()->tag('/x-app-layout')!!}
@else
{!!code()->tag('/x-guest-layout')!!}
@endif