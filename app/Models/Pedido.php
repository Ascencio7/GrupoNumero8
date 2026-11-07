<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'Id_Pedido';
    protected $fillable = ['FechaPedido', 'FechaEntrega', 'Observaciones', 'Id_Cliente'];
    
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'Id_Cliente');
    }
}
