{!!CodeHelper::PHPSOL()!!}

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use {{$model->complete_name}};

class {{$options->event}}
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected ${{CodeHelper::camel($model->name)}};
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct({{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        $this->{{CodeHelper::camel($model->name)}} = ${{CodeHelper::camel($model->name)}};
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
