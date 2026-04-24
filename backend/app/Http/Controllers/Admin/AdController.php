<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdSlot;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $slots = AdSlot::withCount('ads')->orderBy('name')->get();
        $ads   = Ad::with('slot')->latest()->paginate(20);
        return view('admin.ads.index', compact('slots', 'ads'));
    }

    public function storeSlot(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:64|unique:ad_slots,code',
            'name' => 'required|string|max:255',
            'size' => 'nullable|string|max:32',
            'description' => 'nullable|string',
        ]);
        AdSlot::create($data);
        return back()->with('success', 'Зар сурталчилгааны байршил үүслээ.');
    }

    public function destroySlot(AdSlot $slot)
    {
        $slot->delete();
        return back()->with('success', 'Байршил устгагдлаа.');
    }

    public function create()
    {
        $slots = AdSlot::orderBy('name')->get();
        return view('admin.ads.create', compact('slots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slot_id'    => 'required|exists:ad_slots,id',
            'name'       => 'required|string|max:255',
            'type'       => 'required|in:image,html,adsense',
            'image'      => 'nullable|image|max:2048',
            'html_code'  => 'nullable|string',
            'target_url' => 'nullable|url',
            'geo_targets'=> 'nullable|string',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
            'is_active'  => 'nullable|boolean',
        ]);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');
        Ad::create($data);
        return redirect()->route('admin.ads.index')->with('success', 'Зар үүслээ.');
    }

    public function edit(Ad $ad)
    {
        $slots = AdSlot::orderBy('name')->get();
        return view('admin.ads.edit', compact('ad', 'slots'));
    }

    public function update(Request $request, Ad $ad)
    {
        $data = $request->validate([
            'slot_id'    => 'required|exists:ad_slots,id',
            'name'       => 'required|string|max:255',
            'type'       => 'required|in:image,html,adsense',
            'image'      => 'nullable|image|max:2048',
            'html_code'  => 'nullable|string',
            'target_url' => 'nullable|url',
            'geo_targets'=> 'nullable|string',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
            'is_active'  => 'nullable|boolean',
        ]);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');
        $ad->update($data);
        return back()->with('success', 'Зар шинэчлэгдлээ.');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return back()->with('success', 'Зар устгагдлаа.');
    }
}
