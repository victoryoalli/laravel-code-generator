@@extends('layouts.app')
@@section('content')
<div class="container">

    <div class="card mb-4">

        <div class="card-header">
            <h1> {{CodeHelper::title($model->name)}} Show </h1>
        </div>

    <div class="card-body">
        @foreach($model->table->columns as $column)
        @if(!CodeHelper::contains('/id$/',$column->name)&&!CodeHelper::contains('/_at$/',$column->name))
        <div class="form-group">
            <label class="col-form-label" for="value">{{CodeHelper::title($column->name)}}</label>
            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($model->name)}}->{{$column->name}}{{CodeHelper::doubleCurlyClose()}}">
        </div>
        @endif
        @endforeach
    </div>

    </div>

    <div class="card mb-4">

        @foreach($model->relations as $rel)
        @if($rel->type === 'HasMany')
        <div class="card-header">
        <h2>{{CodeHelper::title($rel->name)}}</h2>
        </div>
        <div class="card-body">
            <div>
                <a href="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($rel->model->name))}}.create'){{CodeHelper::doubleCurlyClose()}}">New</a>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        @foreach($rel->model->table->columns as $column)
                        @if($column->type === 'String' || $column->type === 'Text')
                        <th> {{CodeHelper::title($column->name)}}</th>
                        @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{CodeHelper::arroba()}}foreach(${{CodeHelper::camel($model->name)}}->{{CodeHelper::snake($rel->name)}} as ${{CodeHelper::singular($rel->name)}})
                    <tr>
                        <td>
                        <a href="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($rel->model->name))}}.show',['{{CodeHelper::camel($rel->model->name)}}'=>${{CodeHelper::camel($rel->model->name)}}] ){{CodeHelper::doubleCurlyClose()}}">Show</a>
                        <a href="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($rel->model->name))}}.edit',['{{CodeHelper::camel($rel->model->name)}}'=>${{CodeHelper::camel($rel->model->name)}}] ){{CodeHelper::doubleCurlyClose()}}">Edit</a>
                        <a href="javascript:void(0)" onclick="event.preventDefault();
                        document.getElementById('delete-{{CodeHelper::slug($rel->model->name)}}-{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($rel->model->name)}}->id{{CodeHelper::doubleCurlyClose()}}').submit();">
                            {{ __('Delete') }}
                        </a>
                        <form id="delete-{{CodeHelper::slug($rel->model->name)}}-{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($rel->model->name)}}->id{{CodeHelper::doubleCurlyClose()}}" action="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($rel->model->name))}}.destroy',['{{CodeHelper::camel($rel->model->name)}}'=>${{CodeHelper::camel($rel->model->name)}}]){{CodeHelper::doubleCurlyClose()}}" method="POST" style="display: none;">
                            @@csrf
                            @@method('DELETE')
                        </form>
                        </td>
                        @foreach($rel->model->table->columns as $column)
                        @if($column->type === 'String' || $column->type === 'Text')
                        <td> {{CodeHelper::doubleCurlyOpen()}} ${{CodeHelper::camel($rel->model->name)}}->{{$column->name}}{{CodeHelper::doubleCurlyClose()}}</td>
                        @endif
                        @endforeach
                    </tr>

                    @@endforeach
                </tbody>
            </table>
        </div>
        @endif
        @endforeach

    </div>



    <a href="@{{ url()->previous() }}">Back</a>
</div>
@@endsection