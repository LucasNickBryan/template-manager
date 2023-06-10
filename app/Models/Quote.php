<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'destination_id',
        'date_quoted'
    ];

    // define relations
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // render quote id to html format
    public function renderHtml(Quote $quote)
    {
        return '<p>' . $quote->id . '</p>';
    }

    // render quote id and cast to string
    public static function renderText(Quote $quote)
    {
        return (string) $quote->id;
    }
}