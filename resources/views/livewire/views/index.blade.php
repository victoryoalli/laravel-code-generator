<div class="container mx-auto">
    @@if(session('status'))
    <div class="fixed z-20 inset-x-0" x-data="{show:true}" x-show="show" x-cloak>
        <div class="bg-gradient-to-r font-medium font-semibold from-green-500 max-w-4xl mx-auto my-4 px-8 py-4 rounded shadow text-center text-green-50 to-green-600" x-on:click.away="show=false">
            @{{ session('status') }}
        </div>
    </div>
    @@endif
    @@if($show_view == 'show')
    @@include('livewire.{{str($model->name)->plural()->snake()}}.show')
    @@elseif($show_view == 'edit')
    @@include('livewire.{{str($model->name)->plural()->snake()}}.edit')
    @@else
    @@include('livewire.{{str($model->name)->plural()->snake()}}.list')
    @@endif
</div>
