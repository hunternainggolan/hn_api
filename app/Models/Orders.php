<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     // Define table if not using the plural form
     protected $table = 'orders';

     // Specify the fillable or guarded attributes
     protected $fillable = ['user_id'];
 
     // Define relationships (if needed)
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
}
