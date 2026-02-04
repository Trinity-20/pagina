<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Listar productos con filtros
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $status = $request->input('status');
        $featured = $request->input('featured');
        
        $query = Product::with(['category', 'images']);
        
        // Aplicar búsqueda por nombre, descripción, SKU o código de barras
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('barcode', 'like', '%' . $search . '%');
            });
        }
        
        // Filtrar por categoría
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        // Filtrar por estado activo/inactivo
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }
        
        // Filtrar por destacado
        if ($featured !== null && $featured !== '') {
            $query->where('is_featured', $featured);
        }
        
        $products = $query->latest()
                        ->paginate(10)
                        ->appends($request->except('page'));
        
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        return view('products.index', compact('products', 'categories', 'search', 'categoryId', 'status', 'featured'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    // Almacenar nuevo producto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // El slug se generará automáticamente desde el modelo
            // El SKU se generará automáticamente si no se proporciona
            $product = Product::create($validated);

            // Procesar imágenes
            if ($request->hasFile('images')) {
                $mainImageIndex = $request->input('main_image_index', 0);
                $this->processImages($product, $request->file('images'), $mainImageIndex);
            }

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Producto creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }

    // Mostrar producto
    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        return view('products.show', compact('product'));
    }

    // Mostrar formulario de edición
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $product->load('images');
        return view('products.edit', compact('product', 'categories'));
    }

    // Actualizar producto
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // Actualizar producto (el slug se actualizará automáticamente desde el modelo)
            $product->update($validated);

            // Procesar nuevas imágenes
            if ($request->hasFile('images')) {
                $this->processImages($product, $request->file('images'));
            }

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Producto actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }

    // Eliminar producto (soft delete)
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            // Eliminar imágenes del storage
            foreach ($product->images as $image) {
                Storage::delete('public/' . $image->path);
                $image->delete();
            }

            // Eliminar producto (soft delete)
            $product->delete();

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Producto eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    // Procesar y almacenar imágenes
    private function processImages(Product $product, array $images, int $mainImageIndex = 0)
    {
        $order = $product->images()->max('order') ?? 0;

        foreach ($images as $index => $image) {
            // Generar nombre único para la imagen
            $filename = 'product_' . $product->id . '_' . time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Guardar en storage
            $path = $image->storeAs('products', $filename, 'public');

            // Determinar si es la imagen principal
            $isMain = ($index == $mainImageIndex);

            // Crear registro en la base de datos
            $productImage = new ProductImage([
                'path' => $path,
                'alt_text' => $product->name,
                'order' => ++$order,
                'is_main' => $isMain
            ]);

            $product->images()->save($productImage);
        }
    }

    // Eliminar imagen específica
    public function destroyImage(ProductImage $image)
    {
        try {
            // Eliminar archivo del storage
            Storage::delete('public/' . $image->path);

            // Si es la imagen principal, asignar otra como principal
            if ($image->is_main && $image->product->images()->count() > 1) {
                $nextImage = $image->product->images()
                    ->where('id', '!=', $image->id)
                    ->orderBy('order')
                    ->first();
                    
                if ($nextImage) {
                    $nextImage->update(['is_main' => true]);
                }
            }

            // Eliminar registro
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada exitosamente.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    // Establecer imagen como principal
    public function setMainImage(ProductImage $image)
    {
        try {
            // Primero, quitar el estado de principal de todas las imágenes del producto
            $image->product->images()->update(['is_main' => false]);
            
            // Luego, establecer la imagen seleccionada como principal
            $image->update(['is_main' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen establecida como principal.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al establecer imagen principal: ' . $e->getMessage()
            ], 500);
        }
    }

    // Cambiar estado activo/inactivo
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'activado' : 'desactivado';
        return redirect()->route('products.index')
            ->with('success', "Producto {$status} exitosamente.");
    }

    // Cambiar estado destacado
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        $status = $product->is_featured ? 'destacado' : 'quitado de destacados';
        return redirect()->route('products.index')
            ->with('success', "Producto {$status} exitosamente.");
    }

    // Actualizar orden de imágenes
    public function updateImageOrder(Request $request, Product $product)
    {
        try {
            $imageIds = $request->input('image_ids', []);
            
            foreach ($imageIds as $order => $imageId) {
                ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id)
                    ->update(['order' => $order + 1]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Orden de imágenes actualizado.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }

    // Restaurar producto eliminado
    public function restore(Product $product)
    {
        // Para restaurar un producto eliminado con soft delete
        $product->restore();
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Producto restaurado exitosamente.');
    }


    // Vista rápida para API
    public function quickView(Product $product)
    {
        $product->load(['images', 'category']);
        
        $view = view('partials.quick-view', compact('product'))->render();
        
        return response()->json([
            'product' => $product->only(['id', 'name', 'price', 'description']),
            'html' => $view
        ]);
    }


    // Obtener imágenes del producto para el modal
    public function getImages(Product $product)
    {
        $images = $product->images->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => Storage::url($image->path),
                'thumbnail_url' => Storage::url($image->path), // Puedes crear thumbnails si quieres
                'alt' => $image->alt_text,
                'is_main' => $image->is_main,
                'order' => $image->order
            ];
        })->sortBy('order')->values();
        
        return response()->json([
            'success' => true,
            'images' => $images,
            'product_name' => $product->name
        ]);
    }

}