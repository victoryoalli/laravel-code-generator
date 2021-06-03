{!!code()->PHPSOL()!!}

namespace App\Http\Livewire\{{str($model->name)->plural()}};

use {{$model->complete_name}};
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $queryString = ['param_id'];
    public $param_id = null;

    public ${{str($model->name)->snake()}};
    public $show_list;
    public $show_view; //['show', 'edit','list']

    public ${{str($model->name)->lower()}}_id;
@foreach($model->table->columns as $col)
@if(!str($col->name)->matches('/^id|created_at|updated_at$/'))
    public ${{$col->name}};
@endif
@endforeach

    protected $rules = [
@foreach($model->table->columns as $col)
@if(!str($col->name)->matches('/^id$/') && !str($col->name)->matches('/created_at$/') && !str($col->name)->matches('/updated_at$/') && !str($col->name)->matches('/deleted_at$/'))
@if(!$col->nullable)
            '{{$col->name}}' => [ 'required', ],
@else
            '{{$col->name}}' => [ 'present', ],
@endif
@endif
@endforeach
    ];

    public function mount()
    {
        $this->show_view = 'list';
        $this->init();
        if ($this->param_id) {
            $this->edit($this->param_id, 'show');
        }
    }

    public function render()
    {
        return view(
            'livewire.{{str($model->name)->plural()->snake()}}.index',
            [ '{{str($model->name)->plural()->snake()}}' => {{$model->name}}::paginate(5), ]
        )->layout('layouts.guest');
    }

    public function save()
    {
        if ($this->{{str($model->name)->snake()}}_id) {
            $this->update();
        } else {
            $this->store();
        }
    }
    public function create()
    {
        $this->init();
        $this->showView('edit');
    }

    public function store()
    {
        $data = $this->validate();
        {{$model->name}}::create($data);
        session()->flash('status', '{{$model->name}} successfully updated.');
        $this->showView('list');
    }
    public function update()
    {
        $data = $this->validate();
        $this->{{str($model->name)->snake()}} = {{$model->name}}::find($this->{{str($model->name)->snake()}}_id);
        $this->{{str($model->name)->snake()}}->fill($data);
        $this->{{str($model->name)->snake()}}->save();
        session()->flash('status', '{{$model->name}} successfully updated.');
        $this->init();
        $this->showView('list');
    }

    public function edit(${{str($model->name)->snake()}}_id, $view = 'edit')
    {
        $this->{{str($model->name)->snake()}}_id = ${{str($model->name)->snake()}}_id;
        $this->{{str($model->name)->snake()}} = {{$model->name}}::find($this->{{str($model->name)->snake()}}_id);
@foreach($model->table->columns as $col)
@if(!str($col->name)->matches('/^id|created_at|updated_at$/'))
@if(str($col->name)->matches('/_at$/'))
        $this->{{$col->name}} = $this->{{str($model->name)->snake()}}->{{$col->name}}->format('Y-m-d');
@else
        $this->{{$col->name}} = $this->{{str($model->name)->snake()}}->{{$col->name}};
@endif
@endif
@endforeach
        $this->showView($view);
    }
    public function delete($id)
    {
        {{$model->name}}::destroy($id) ;
        $this->init();
    }

    public function showView($view)
    {
        $this->show_view = $view;
    }

    public function init()
    {
        $this->resetErrorBag();
        $this->resetValidation();
@foreach($model->table->columns as $col)
@if(!str($col->name)->matches('/^id|created_at|updated_at$/'))
        $this->{{$col->name}} = null;
@endif
@endforeach
    }

    public function goTo($path, $param_id)
    {
        return redirect()->to("{$path}?param_id={$param_id}");
    }
}
