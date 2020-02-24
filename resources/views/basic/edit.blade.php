@@extends('layouts.app')
@@section('content')
<div class="container">
    <div class="card">

        <div class="card-header">
            <h1> {{CodeHelper::title($model->name)}} Edit </h1>
        </div>
        <div class="card-body">

    @@if ($errors->any())
    <ul>
        @@foreach ($errors->all() as $error)
        <li class="text-danger">@{{ $error }}</li>
        @@endforeach
    </ul>

    @@endif

    <form action="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.update',['{{CodeHelper::snake($model->name)}}'=>${{CodeHelper::snake($model->name)}}->id]){{CodeHelper::doubleCurlyClose()}}" method="POST" novalidate>
        @@csrf
        @@method('PUT')
        @foreach($model->relations as $rel)
        @if($rel->type === 'BelongsTo')
        <div class="form-group">
            <label for="{{$rel->local_key}}">{{CodeHelper::title($rel->name)}}</label>
            <select class="form-control" name="{{$rel->local_key}}" id="{{$rel->local_key}}">
                {{CodeHelper::arroba()}}foreach((\{{$rel->model->complete_name}}::all() ?? [] ) as ${{$rel->name}})
                <option value="{{CodeHelper::doubleCurlyOpen()}}${{$rel->name}}->id{{CodeHelper::doubleCurlyClose()}}"
                    {{CodeHelper::arroba()}}if(${{CodeHelper::snake($model->name)}}->{{$rel->local_key}} == old('{{$rel->local_key}}', ${{$rel->name}}->id))
                    selected="selected"
                    @@endif
                >{{CodeHelper::doubleCurlyOpen()}}${{$rel->name}}->{{collect($rel->model->table->columns)->filter(function($col,$key) {
                    return $col->type == 'String'; })->map(function($col){ return $col->name;})->first()}}{{CodeHelper::doubleCurlyClose()}}</option>

                @@endforeach
            </select>
        </div>
        @endif
        @endforeach


        @foreach($model->table->columns as $column)
        @if(!CodeHelper::contains('/id$/',$column->name) && !CodeHelper::contains('/created_at$/',$column->name) && !CodeHelper::contains('/updated_at$/',$column->name) && !CodeHelper::contains('/deleted_at$/',$column->name))
        <div class="form-group">
            <label for="{{$column->name}}">{{CodeHelper::title($column->name)}}</label>
        @if($column->type=='Text')
            <textarea class="form-control {{$column->type}}"  name="{{$column->name}}" id="{{$column->name}}" cols="30" rows="10">{{CodeHelper::doubleCurlyOpen()}}old('{{$column->name}}',${{CodeHelper::snake($model->name)}}->{{$column->name}}){{CodeHelper::doubleCurlyClose()}}</textarea>
        @else
            <input class="form-control {{$column->type}}" @if($column->type == 'Integer') type="number" @elseif($column->type == 'Date') type="date" @else type="text" @endif name="{{$column->name}}" id="{{$column->name}}" value="{{CodeHelper::doubleCurlyOpen()}}old('{{$column->name}}',${{CodeHelper::snake($model->name)}}->{{$column->name}}){{CodeHelper::doubleCurlyClose()}}"
            @if($column->type == '\String')
            maxlength="{{$column->length}}"
            @endif
            @if(!$column->nullable)
            required="required"
            @endif
            >
        @endif
            @@if($errors->has('{{$column->name}}'))
            <p class="text-danger">{{CodeHelper::doubleCurlyOpen()}}$errors->first('{{$column->name}}'){{CodeHelper::doubleCurlyClose()}}</p>
            @@endif
        </div>
        @endif
        @endforeach
        <div>
            <button class="btn btn-primary" type="submit">Save</button>
            <a href="@{{ url()->previous() }}">Back</a>
        </div>
    </form>
    </div>
        </div>

</div>
@@endsection