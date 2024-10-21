<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function extendBuilder(Builder &$builder, array $value)
    {
        foreach ($value as $key => $item) {
           $builder->when(isset($item), function ($q) use ($item, $key) {
                $q->where($key, 'like', '%'.$item.'%');
            });
        }
    }
    public function index(Request $request)
    {
        $name = $request->name ?? null;
        $descriptions = $request->description ?? null;
        $query = Product::withoutTrashed();
        $this->extendBuilder($query, ['name' => $name, 'description' => $descriptions]);
        $descriptions = $query->get(['description', 'name','id']);
        return response()->json($descriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $validate = $request->validate([
//            'name' => 'required',
//            'description' => 'required',
//            'price' => 'required',
//        ]);
//        return Product::query()->create($validate);

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z]+$/u',
            'description' => 'required|min:10|max:255',
            'price' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        return Product::query()->create($validator->valid());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::query()->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        $product = Product::query()->findOrFail($id);
        $product->update($validate);
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::query()->findOrFail($id);
        $product->delete();
        return $product;
    }
}
