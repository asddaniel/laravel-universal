<?php

namespace Asddaniel\UniversalLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Colonne extends Model
{
    use HasFactory;

    protected $fillable = [
        "table_id",
        "name"
    ];
    /**
     * Get the table associated with the Colonne
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function table(): HasOne
    {
        return $this->hasOne(Donnee::class, 'id', 'table_id');
    }
}
