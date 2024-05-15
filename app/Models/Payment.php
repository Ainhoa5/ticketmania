<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Payment
 *
 * Representa un pago en el sistema.
 *
 * @package App\Models
 *
 * @property int $id Identificador único del pago
 * @property int $user_id Identificador del usuario asociado al pago
 * @property int $ticket_id Identificador del boleto asociado al pago
 * @property float $amount Monto del pago
 * @property string $status Estado del pago (e.g., 'pending', 'completed')
 * @property string $stripe_payment_id Identificador del pago en Stripe
 *
 * @property-read User $user Usuario asociado al pago
 * @property-read Ticket $ticket Boleto asociado al pago
 */
class Payment extends Model
{
    use HasFactory;

    /**
     * Atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'ticket_id', 'amount', 'status', 'stripe_payment_id'];

    /**
     * Obtiene el usuario asociado al pago.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el boleto asociado al pago.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
