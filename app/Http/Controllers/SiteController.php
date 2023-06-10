<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @param int $id
     *
     * @return Site
     */
    public function getById($id)
    {
        $site = Site::find($id);

        return $site;
    }
}
