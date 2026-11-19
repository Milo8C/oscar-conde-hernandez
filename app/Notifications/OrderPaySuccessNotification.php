<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaySuccessNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected Order $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $totalFormateado = '$' . number_format($this->order->total, 2);

        return (new MailMessage)
            ->subject('Pago Exitoso - Orden #' . $this->order->order_code)
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Hemos recibido correctamente el pago de tu pedido.')
            ->line('Detalles del pedido:')
            ->line('- **Número de pedido:** ' . $this->order->order_code)
            ->line('- **Fecha:** ' . $this->order->paid_at->format('d/m/Y'))
            ->line('- **Total:** ' . $totalFormateado)
            ->line('Puedes ver los detalles completos de tu pedido en tu perfil.')
            ->action('Ver Pedido', route('orders.show', $this->order->slug))
            ->line('Gracias por tu compra.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
