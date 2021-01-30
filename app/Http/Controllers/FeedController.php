<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Converters\FeedConverter;

class FeedController extends Controller
{
    public function generateFromUrl(Request $request){
        if ($request->has('feed-url')) {
            $url = $request->input('feed-url');

            $feedConverter = new FeedConverter($url);
            $pdf = $feedConverter->getPdfFromFeed();

            return response()->download($pdf->Output());
        } else {
            abort(400, "Bad Request");
        }
    }
}
