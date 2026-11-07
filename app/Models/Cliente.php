<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'Id_Cliente';

    protected $fillable = ['Nombre', 'Apellido', 'Fecha_Nac'];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'Id_Cliente', 'Id_Cliente');
    }
}
