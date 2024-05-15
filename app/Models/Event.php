<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Event
 *
 * Representa un evento en el sistema.
 *
 * @package App\Models
 *
 * @property int $id Identificador único del evento
 * @property string $name Nombre del evento
 * @property string $description Descripción del evento
 * @property string $image_cover URL de la imagen de portada del evento
 * @property string $image_background URL de la imagen de fondo del evento
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Concert[] $concerts Conciertos asociados al evento
 */
class Event extends Model
{
    use HasFactory;

    /**
     * Atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'image_cover', 'image_background'];

    /**
     * Obtiene los conciertos asociados al evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function concerts()
    {
        return $this->hasMany(Concert::class);
    }
}
