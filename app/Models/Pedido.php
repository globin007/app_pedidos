<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['numero_pedido', 'fecha_pedido', 'fecha_recepcion', 'fecha_despacho', 'fecha_entrega', 'vendedor_id', 'repartidor_id', 'estado'];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Relación con el vendedor (usuario)
    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    // Relación con el repartidor (usuario)
    public function repartidor()
    {
        return $this->belongsTo(User::class, 'repartidor_id');
    }
}
