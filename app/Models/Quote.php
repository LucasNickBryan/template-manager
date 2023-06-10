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

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function renderHtml(Quote $quote)
    {
        return '<p>' . $quote->id . '</p>';
    }

    public static function renderText(Quote $quote)
    {
        return (string) $quote->id;
    }
}