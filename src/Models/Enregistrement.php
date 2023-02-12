<?php

namespace Asddaniel\UniversalLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enregistrement extends Model
{
    use HasFactory;
    protected $fillable = [
        "table_id"
    ];

    /**
     * Get all of the relations for the Enregistrement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relations(): HasMany
    {
        return $this->hasMany(Relation::class, 'origine', 'id');
    }
}
