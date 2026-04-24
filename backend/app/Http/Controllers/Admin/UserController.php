<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->latest()->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|in:admin,editor,author',
            'send_invite' => 'nullable|boolean',
        ]);

        $token = Str::random(48);
        $user = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'role'         => $data['role'],
            'is_admin'     => $data['role'] === 'admin',
            'status'       => 'invited',
            'invite_token' => $token,
            'password'     => Hash::make(Str::random(32)),
        ]);

        ActivityLog::record('user.invited', $user, "Хэрэглэгчийг урьсан: {$user->email}");
        return redirect()->route('admin.users.index')
            ->with('success', "Урилгын линк: " . url('/admin/invite/' . $token));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'role'   => 'required|in:admin,editor,author',
            'status' => 'required|in:active,suspended,invited',
            'password' => 'nullable|string|min:8',
        ]);
        $update = [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'role'     => $data['role'],
            'is_admin' => $data['role'] === 'admin',
            'status'   => $data['status'],
        ];
        if (! empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }
        $user->update($update);
        ActivityLog::record('user.updated', $user, "Хэрэглэгчийг шинэчилсэн");
        return redirect()->route('admin.users.index')->with('success', 'Хэрэглэгч шинэчлэгдлээ.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Та өөрийгөө устгах боломжгүй.');
        }
        $user->delete();
        ActivityLog::record('user.deleted', $user, "Хэрэглэгчийг устгасан");
        return back()->with('success', 'Хэрэглэгч устгагдлаа.');
    }

    public function suspend(User $user)
    {
        $user->update(['status' => $user->status === 'suspended' ? 'active' : 'suspended']);
        ActivityLog::record('user.status', $user, "Төлөв: {$user->status}");
        return back()->with('success', 'Төлөв шинэчлэгдлээ.');
    }
}
