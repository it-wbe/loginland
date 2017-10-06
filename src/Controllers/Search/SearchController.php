<?php

namespace Wbe\Login\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('login::search.titleSearch');
    }

    public function result(Request $request, $search)
    {
        return $search;
    }
}
