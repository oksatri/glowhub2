<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\ContentSection;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Load published content sections (with details) so front can render CMS-managed sections
        $contents = ContentSection::with('details')
            ->where('status', 'publish')
            ->orderBy('order', 'asc')
            ->get();

        return view('front.home', compact('contents'));
    }
}
