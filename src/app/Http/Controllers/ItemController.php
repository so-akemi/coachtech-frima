<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index() {
    $items = Item::all();
    dd($items); // ここでアイテムの内容を確認

    return view('items.index', compact('items'));
}
}
