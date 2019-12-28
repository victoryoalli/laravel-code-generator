@@extends('layouts.app')
@@section('content')
<div class="container">
    <h1> {{CodeHelper::title($model->name)}} Show </h1>

    @foreach($model->table->columns as $column)
    @if(!CodeHelper::contains('/id$/',$column->name)&&!CodeHelper::contains('/_at$/',$column->name))

    <div class="form-group">
        <label for="value">{{CodeHelper::title($column->name)}}</label>
        <p>{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($model->name)}}->{{$column->name}}{{CodeHelper::doubleCurlyClose()}}</p>
    </div>
    @endif
    @endforeach

    <a href="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.index'){{CodeHelper::doubleCurlyClose()}}">Back</a>
</div>
@@endsection