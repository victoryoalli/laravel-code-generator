@@extends('layouts.app')
@@section('content')
<div class="container">

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <h1> {{CodeHelper::title(CodeHelper::plural($model->name))}} </h1>
    <div>
        <a href="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.create'){{CodeHelper::doubleCurlyClose()}}">New</a>
    </div>
    <table class="table table-striped">
        @@if(count(${{CodeHelper::slug(CodeHelper::plural($model->name))}}))
        <thead>
            <tr>
                <th>&nbsp;</th>
                @foreach($model->table->columns as $column)
                @if(!CodeHelper::contains('/id$/',$column->name)&&!CodeHelper::contains('/_at$/',$column->name))
                <td>{{CodeHelper::title($column->name)}}</td>
                @endif

                @endforeach
            </tr>

        </thead>
        @@endif
        <tbody>
            @@forelse(${{CodeHelper::slug(CodeHelper::plural($model->name))}} as ${{CodeHelper::camel($model->name)}})
            <tr>
                <td>
                    <a href="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.show',['{{CodeHelper::camel($model->name)}}'=>${{CodeHelper::camel($model->name)}}] ){{CodeHelper::doubleCurlyClose()}}">Show</a>
                    <a href="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.edit',['{{CodeHelper::camel($model->name)}}'=>${{CodeHelper::camel($model->name)}}] ){{CodeHelper::doubleCurlyClose()}}">Edit</a>
                    <a href="javascript:void(0)" onclick="event.preventDefault();
                    document.getElementById('delete-{{CodeHelper::slug($model->name)}}-{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($model->name)}}->id{{CodeHelper::doubleCurlyClose()}}').submit();">
                        {{ __('Delete') }}
                    </a>
                    <form id="delete-{{CodeHelper::slug($model->name)}}-{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($model->name)}}->id{{CodeHelper::doubleCurlyClose()}}" action="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.destroy',['{{CodeHelper::camel($model->name)}}'=>${{CodeHelper::camel($model->name)}}]){{CodeHelper::doubleCurlyClose()}}" method="POST" style="display: none;">
                        @@csrf
                        @@method('DELETE')
                    </form>
                </td>
                @foreach($model->table->columns as $column)
                @if(!CodeHelper::contains('/id$/',$column->name)&&!CodeHelper::contains('/_at$/',$column->name))
                <td>{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($model->name)}}->{{$column->name}}{{CodeHelper::doubleCurlyClose()}}</td>
                @endif
                @endforeach

            </tr>
            @@empty
            <p>No {{CodeHelper::title(CodeHelper::plural($model->name))}}</p>
            @@endforelse
        </tbody>
    </table>

</div>

@@endsection