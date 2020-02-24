{!! CodeHelper::PHPSOL() !!}

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class {{$model->name}}PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
@foreach($model->table->columns as $col)
@if(!CodeHelper::contains('/^id$/',$col->name) && !CodeHelper::contains('/created_at$/',$col->name) && !CodeHelper::contains('/updated_at$/',$col->name) && !CodeHelper::contains('/deleted_at$/',$col->name))
@if(!$col->nullable)
            '{{$col->name}}' => [
                'required',
            ],
@else
            '{{$col->name}}' => [
                'present',
            ],
@endif
@endif
@endforeach
        ];
    }
}
