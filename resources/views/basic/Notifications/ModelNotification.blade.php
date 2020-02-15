{!!CodeHelper::PHPSOL()!!}

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use {{$model->complete_name}};

class {{$model->name}}Notification extends Notification
{
    use Queueable;

    protected ${{CodeHelper::camel($model->name)}};
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct({{$model->name}} ${{CodeHelper::camel($model->name)}})
    {
        $this->${{CodeHelper::camel($model->name)}} = ${{CodeHelper::camel($model->name)}};
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage($this->{{CodeHelper::camel($model->name)}}))
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
