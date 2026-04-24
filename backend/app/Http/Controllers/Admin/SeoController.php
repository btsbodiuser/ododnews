<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $settings = [
            'site_title'        => Setting::get('seo.site_title', 'ODOD News'),
            'site_description'  => Setting::get('seo.site_description', 'Одод. Цуурхал. Загвар.'),
            'default_og_image'  => Setting::get('seo.default_og_image', ''),
            'twitter_handle'    => Setting::get('seo.twitter_handle', ''),
            'fb_app_id'         => Setting::get('seo.fb_app_id', ''),
            'robots'            => Setting::get('seo.robots', "User-agent: *\nAllow: /"),
            'google_verification' => Setting::get('seo.google_verification', ''),
            'enable_sitemap'    => Setting::get('seo.enable_sitemap', '1'),
            'enable_schema'     => Setting::get('seo.enable_schema', '1'),
        ];

        $missingMeta = Article::published()
            ->where(function ($q) {
                $q->whereNull('seo_title')->orWhere('seo_title', '')
                  ->orWhereNull('seo_description')->orWhere('seo_description', '');
            })->count();

        return view('admin.seo.index', compact('settings', 'missingMeta'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_title'          => 'nullable|string|max:255',
            'site_description'    => 'nullable|string|max:500',
            'default_og_image'    => 'nullable|string|max:500',
            'twitter_handle'      => 'nullable|string|max:100',
            'fb_app_id'           => 'nullable|string|max:100',
            'robots'              => 'nullable|string',
            'google_verification' => 'nullable|string|max:255',
            'enable_sitemap'      => 'nullable|boolean',
            'enable_schema'       => 'nullable|boolean',
        ]);

        foreach ($data as $key => $value) {
            Setting::set("seo.$key", $value, 'seo');
        }
        return back()->with('success', 'SEO тохиргоо хадгалагдлаа.');
    }

    /** Public sitemap.xml */
    public function sitemap()
    {
        $articles   = Article::published()->select('slug', 'updated_at')->get();
        $categories = Category::select('slug', 'updated_at')->get();
        return response()->view('seo.sitemap', compact('articles', 'categories'))
            ->header('Content-Type', 'application/xml');
    }

    /** Public robots.txt */
    public function robots()
    {
        $body = Setting::get('seo.robots', "User-agent: *\nAllow: /\n\nSitemap: " . url('/sitemap.xml'));
        return response($body, 200, ['Content-Type' => 'text/plain']);
    }
}
