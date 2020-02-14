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
@if(!CodeHelper::contains('/id$/',$col->name) && !CodeHelper::contains('/_at$/',$col->name))
        '{{$col->name}}' => [
@if(!$col->nullable)
            'required',
@endif
        ],
@endif
@endforeach
        ];
    }
}
