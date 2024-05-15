<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Ticket
 *
 * Representa un boleto en el sistema.
 *
 * @package App\Models
 *
 * @property int $id Identificador único del boleto
 * @property int $concert_id Identificador del concierto asociado
 * @property int $user_id Identificador del usuario asociado al boleto
 *
 * @property-read Concert $concert Concierto asociado al boleto
 * @property-read User $user Usuario asociado al boleto
 * @property-read Payment $payment Pago asociado al boleto
 */
class Ticket extends Model
{
    use HasFactory;

    /**
     * Atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = ['concert_id', 'user_id'];

    /**
     * Obtiene el concierto asociado al boleto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    /**
     * Obtiene el usuario asociado al boleto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el pago asociado al boleto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
