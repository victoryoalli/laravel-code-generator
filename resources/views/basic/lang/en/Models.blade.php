{!! CodeHelper::PHPSOL() !!}

return [
    'singular' => '{{CodeHelper::title($model->name)}}',
    'plural' => '{{CodeHelper::title(CodeHelper::plural($model->name))}}',
//Fields
@foreach($model->table->columns as $column)
    '{{CodeHelper::snake($column->name)}}' => '{{CodeHelper::title($column->name)}}',
@endforeach
//Relations
@foreach($model->relations as $rel)
    '{{CodeHelper::snake($rel->name)}}' => '{{CodeHelper::title($rel->name)}}',
@endforeach
//Custom
];