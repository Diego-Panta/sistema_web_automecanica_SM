<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accione extends Model
{
    // Relación con acciones realizadas
    public function realizaciones()
    {
        return $this->hasMany(AccionRealizada::class, 'accion_id');
    }

    // Relaciones many-to-many (puedes mantenerlas como atajos o eliminarlas)
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'acciones_realizadas', 'accion_id', 'lead_id')
            ->using(AccionRealizada::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'acciones_realizadas', 'accion_id', 'user_id')
            ->using(AccionRealizada::class);
    }
}
