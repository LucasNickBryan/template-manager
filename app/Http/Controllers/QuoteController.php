<?php

namespace App\Http\Controllers;

use App\Models\Quote;

/**
 * @param int $id
 *
 * @return Quote
 */
class QuoteController extends Controller
{
    public function getById($id)
    {
        $quote = Quote::find($id);
        
        return $quote;
    }
}
