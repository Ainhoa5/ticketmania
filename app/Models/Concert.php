<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Concert
 *
 * Representa un concierto en el sistema.
 *
 * @package App\Models
 *
 * @property int $id Identificador único del concierto
 * @property int $event_id Identificador del evento asociado
 * @property string $date Fecha del concierto
 * @property string $location Ubicación del concierto
 * @property int $capacity_total Capacidad total del concierto
 * @property int $tickets_sold Número de boletos vendidos
 * @property float $price Precio de los boletos del concierto
 *
 * @property-read Event $event Evento asociado al concierto
 * @property-read \Illuminate\Database\Eloquent\Collection|Ticket[] $tickets Boletos asociados al concierto
 */
class Concert extends Model
{
    use HasFactory;

    /**
     * Atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = ['event_id', 'date', 'location', 'capacity_total', 'tickets_sold', 'price'];

    /**
     * Obtiene el evento asociado al concierto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Obtiene los boletos asociados al concierto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
