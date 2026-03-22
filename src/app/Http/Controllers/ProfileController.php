<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $currentPage = $request->query('page', 'sell');

        $sellItems = collect();
        $buyItems = collect();

        if ($currentPage === 'buy') {
            $buyItems = Item::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $sellItems = Item::where('user_id', $user->id)->get();
        }

        return view('profile.index', compact('user', 'sellItems', 'buyItems', 'currentPage'));
    }

    public function edit()
    {
        $user = auth()->user();

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            if ($user->image_url) {
                Storage::disk('public')->delete($user->image_url);
            }

            $path = $request->file('image')->store('profiles', 'public');
            $user->image_url = $path;
        }

        $user->update([
            'name' => $request->user_name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        $user->save();

        return redirect('/')->with('message', 'プロフィールを更新しました');
    }
}
