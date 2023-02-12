<?php

namespace Asddaniel\UniversalLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donnee extends Model
{
    use HasFactory;
    protected $fillable = [
        "colonne_id",
        "values"
    ];
    /**
     * Get the colonne associated with the Donnees
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colonne(): HasOne
    {
        return $this->hasOne(Colonne::class, 'id', 'colonne_id');
    }

    /**
     * Get all of the colonnes for the Donnee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colonnes(): HasMany
    {
        return $this->hasMany(Colonne::class, 'table_id', 'id');
    }
}
