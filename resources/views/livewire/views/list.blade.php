<div class="py-8">
    <div class=" mx-auto">
        <h1 class="text-3xl text-blue-500 font-bold"> {{str($model->name)->human()->title()->plural()}} </h1>
        {!!code()->tag('x-slot name="header"')!!} {{str($model->name)->human()->plural()->title()}} {!! code()->tag('/x-slot') !!}
    </div>
    <div class=" mx-auto flex justify-end my-8">
        <button wire:click="create()" class="text-blue-50 bg-blue-500 px-5 py-1.5 rounded hover:bg-blue-700">Create {{$model->name}}</button>
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
                            <span wire:click="edit({{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->id{{code()->doubleCurlyClose()}},'show')" class="cursor-pointer text-blue-400 hover:text-blue-500">Show</span>
                            <span wire:click="edit({{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->id{{code()->doubleCurlyClose()}})" class="cursor-pointer text-blue-400 hover:text-blue-500">Edit</span>
                            <span wire:click="delete({{code()->doubleCurlyOpen()}}${{str($model->name)->snake()}}->id{{code()->doubleCurlyClose()}})" class="cursor-pointer text-blue-400 hover:text-blue-500"> Delete </span>
                        </div>
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
