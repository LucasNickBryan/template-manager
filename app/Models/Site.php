<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [ 'url' ];

    public function quote()
    {
        return $this->hasMany(Quote::class);
    }
}
