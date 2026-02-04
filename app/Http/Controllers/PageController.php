<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $products = Product::where('is_active', true)
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(9); // 9 productos (3 filas de 3)
            
        $categories = Category::where('is_active', true)->get();
        
        if ($request->ajax()) {
            $view = view('partials.product-grid', compact('products'))->render();
            return response()->json([
                'html' => $view,
                'pagination' => $products->links()->toHtml()
            ]);
        }
        
        return view('home', compact('products', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        return view('services');
    }

    public function contact()
    {
        return view('contact');
    }
}