
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class {{ $model -> name }}
{
    @foreach($model -> table -> columns as $c) { { $c -> name } }, @endforeach
}