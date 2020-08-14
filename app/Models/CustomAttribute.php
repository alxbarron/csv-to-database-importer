<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class CustomAttribute extends Model
{
    /* Contact Relation */
    public function contact()
    {
        return $this->belongsTo(Contact);
    }

    protected $fillable = ['contact_id', 'key', 'value'];
}
