<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationshipType extends Model
{
    protected $table = 'relationship_types';
    protected $fillable = ['name'];


    public function relationships() {
        return $this->hasMany(Relationship::class, 'relationship_type_id');
    }
}