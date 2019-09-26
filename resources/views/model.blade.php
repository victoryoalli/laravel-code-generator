{!! LCG::PHP_SOL !!}
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class {{$model->name}} extends Authenticatable
{
use Notifiable;

/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
@foreach($model->table->columns as $c) {{$c->name}}, @endforeach

];

}