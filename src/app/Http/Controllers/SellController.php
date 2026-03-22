<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $imagePath = $request->file('image')->store('item_images', 'public');

        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imagePath,
            'condition' => $request->condition,
            'brand' => $request->brand,
        ]);

        if ($request->categories) {
            $item->categories()->attach($request->categories);
        }

        return redirect('/')->with('message', '商品を出品しました');
    }
}
