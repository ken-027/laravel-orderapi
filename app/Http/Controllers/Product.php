<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product as MProduct;

class Product extends Controller
{
    public function list()
    {
        return response(MProduct::all(), 200);
    }
}