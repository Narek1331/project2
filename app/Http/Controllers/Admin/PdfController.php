<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    SiteKeyword,
    User
};

class PdfController extends Controller
{
     public function index(Request $request)
    {
        $token = $request->token;

        if (!$token) {
            abort(404);
        }

        $user = User::where('token', $token)->first();

        if (!$user) {
            abort(404);
        }

        $userId = $user->id;

        $siteKeywords = SiteKeyword::with('site')
            ->whereHas('site', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('status', true);
            })
            ->get();

        $lines = $siteKeywords->map(function ($keyword) {
            $domain = $keyword->site->domain;
            $name = $keyword->name ?? '';
            $url = $keyword->url ?? '';
            $clicks = $keyword->clicks_per_day ?? 0;
            $region = $keyword->site->region;
            $yandex = 'Яндекс';

            return "{$domain}:{$url}:{$name}:{$clicks}:{$region}:{$yandex}";
        });

        $content = $lines->implode("\n");

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
