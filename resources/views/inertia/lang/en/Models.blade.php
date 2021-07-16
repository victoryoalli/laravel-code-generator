{!! code()->PHPSOL() !!}

return [
    'singular' => '{{str($model->name)->human()->title()}}',
    'plural' => '{{str($model->name)->plural()->human()->title()}}',
//Fields
@foreach($model->table->columns as $column)
    '{{str($column->name)->snake()}}' => '{{str($column->name)->human()->title()}}',
@endforeach
//Relations
@foreach($model->relations as $rel)
    '{{str($rel->name)->snake()}}' => '{{str($rel->name)->human()->title()}}',
@endforeach
//Custom
];