<?php

namespace Asddaniel\UniversalLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Relation extends Model
{
    use HasFactory;
    protected $fillable = [
        "origine",
        "destination"
    ];

    /**
     * Get the donnee associated with the Relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function donnee(): HasOne
    {
        return $this->hasOne(Donnee::class, 'id', 'destination');
    }


}
