<?php

namespace App\Http\Controllers\Web;

use App\Actions\Search\RunSearchAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function __invoke(Request $request)
    {
        $results = RunSearchAction::run($request->q);

        return response()->json(['results' => $results], 200);
    }
}
