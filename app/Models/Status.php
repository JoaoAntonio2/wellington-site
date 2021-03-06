<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     * Tabela para ser usada no model
     */
    protected $table = 'status';

    /**
     * Um status tem varios pedidos
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
    	return $this->hasMany(Order::class);
    }
}
