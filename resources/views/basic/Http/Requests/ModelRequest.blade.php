{!! CodeHelper::PHPSOL() !!}

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class {{$model->name}}Request extends FormRequest
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
@if(!str($col->name)->match('/^id$/') && !str($col->name)->match('/created_at$/') && !str($col->name)->match('/updated_at$/') && !str($col->name)->match('/deleted_at$/'))
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
