@@extends('layouts.app')
@@section('content')
<div class="container">
    <h1> {{CodeHelper::title($model->name)}} Show </h1>

    @foreach($model->table->columns as $column)
    @if(!CodeHelper::contains('/id$/',$column->name)&&!CodeHelper::contains('/_at$/',$column->name))

    <div class="form-group">
        <label for="value">{{CodeHelper::title($column->name)}}</label>
        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{CodeHelper::doubleCurlyOpen()}}${{CodeHelper::camel($model->name)}}->{{$column->name}}{{CodeHelper::doubleCurlyClose()}}">
    </div>
    @endif
    @endforeach

    <a href="@{{ url()->previous() }}">Back</a>
</div>
@@endsection