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

class {{$model->name}}{{$options->event}}
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected ${{str($model->name)->camel()}};
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct({{$model->name}} ${{str($model->name)->camel()}})
    {
        $this->{{str($model->name)->camel()}} = ${{str($model->name)->camel()}};
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
