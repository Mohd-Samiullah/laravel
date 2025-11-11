<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;
    protected $table = 'employee';
    protected $primaryKey = 'id';

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    // public function getDateAttribute($value){
    //     return date('d M, Y',strtotime($value));
    // }

}
