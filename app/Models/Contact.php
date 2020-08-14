<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomAttribute;

class Contact extends Model
{
    protected $fillable = ['team_id', 'name', 'phone', 'email', 'sticky_phone_number_id'];

    /* Custom Attributes Relation */
    public function customAttributes()
    {
        return $this->hasMany(CustomAttribute::class);
    }
}
