<?php

namespace App\Http\Controllers;

use App\Models\Destination;

/**
 * @param int $id
 *
 * @return Destination
 */
class DestinationController extends Controller
{
    public function getById($id)
    {
        $destination = Destination::find($id);

        return $destination;
    }
}
