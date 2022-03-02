<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoModelo extends Model
{
    use HasFactory;

    protected $table = 'modelos_productos';

    protected  $primaryKey = 'id';

    protected $fillable = ['nombre_modelo', 'descripcion_modelo'];

    //Creamos la relacion con productos
    public function productos() {
        return $this->belongsTo(Producto::class);
    }
}
