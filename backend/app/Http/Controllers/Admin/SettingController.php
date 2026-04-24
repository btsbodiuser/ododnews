<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $g = fn (string $k, $d = null) => Setting::get($k, $d);
        $settings = [
            'general' => [
                'site_name'     => $g('general.site_name', 'ODOD News'),
                'site_tagline'  => $g('general.site_tagline', 'Одод. Цуурхал. Загвар.'),
                'logo'          => $g('general.logo', ''),
                'favicon'       => $g('general.favicon', ''),
                'language'      => $g('general.language', 'mn'),
                'timezone'      => $g('general.timezone', 'Asia/Ulaanbaatar'),
                'maintenance'   => $g('general.maintenance', '0'),
            ],
            'social' => [
                'facebook'  => $g('social.facebook', ''),
                'instagram' => $g('social.instagram', ''),
                'youtube'   => $g('social.youtube', ''),
                'tiktok'    => $g('social.tiktok', ''),
                'twitter'   => $g('social.twitter', ''),
            ],
            'analytics' => [
                'ga_id'      => $g('analytics.ga_id', ''),
                'fb_pixel'   => $g('analytics.fb_pixel', ''),
                'head_html'  => $g('analytics.head_html', ''),
                'body_html'  => $g('analytics.body_html', ''),
            ],
            'mail' => [
                'driver'        => $g('mail.driver', 'smtp'),
                'mailchimp_key' => $g('mail.mailchimp_key', ''),
                'mailchimp_list'=> $g('mail.mailchimp_list', ''),
            ],
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $group = $request->input('group', 'general');
        $payload = $request->except(['_token', 'group', '_method']);

        if ($request->hasFile('logo')) {
            $payload['logo'] = $request->file('logo')->store('settings', 'public');
        }
        if ($request->hasFile('favicon')) {
            $payload['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        foreach ($payload as $key => $value) {
            if (is_array($value)) continue;
            Setting::set("$group.$key", (string) $value, $group);
        }
        return back()->with('success', 'Тохиргоо хадгалагдлаа.');
    }
}
