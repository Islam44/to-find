<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use DB;
use Illuminate\Http\Request;

class categoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Admin'])->only('store');
    }

    public function store(Request $request)
    {

        $category = Category::create([
            'category_name' => $request->category_name,
            'category_name_ar' => $request->category_ar,
        ]);
        return response()->json($category);
    }

    public function admincategory()
    {
        $categories = Category::all();
        // dd($users);
        return view('layouts.AdminPanel.category.index', ['categories' => $categories]);
    }

    public function createCategory()
    {

        return view('layouts.AdminPanel.category.create');
    }

    public function storeCategory(Request $request)
    {
        Category::create([
            'category_name' => $request->Category_name,
        ]);

        return redirect('/admin/panel/categorytable');
    }

    public function destroyCategory($id)
    {
        Category::find($id)->delete();
        return redirect('/admin/panel/categorytable');
    }

    public function edit22Admin(Category $category)
    {
        $attributeOfCategory = $category->attributes;
        $attributes = Attribute::with('categoryAttribute')->get();
        return view('layouts.AdminPanel.categoryAdmin.edit', [
            'category' => $category,
            'attributeOfCategory' => $attributeOfCategory,
            'attributes' => $attributes
        ]);
    }

    public function index22Admin()
    {
        $categories = Category::with('attributes')->get();
        return view('layouts.AdminPanel.categoryAdmin.index', ['categories' => $categories]);
    }

    public function create22Admin(Category $category)
    {
        $attributeOfCategory = $category->attributes;
        $attributes = Attribute::with('categoryAttribute')->get();
        return view('layouts.AdminPanel.categoryAdmin.create', [
            'attributeOfCategory' => $attributeOfCategory
            , 'attributes' => $attributes]);
    }

    public function stores22Admin(Request $request)
    {
        DB::transaction(function () use ($request) {
            $category = Category::create([
                'category_name' => $request->input('category_name'),
            ]);

            $attribute = Attribute::create([
                'attribute_name' => $request->input('attribute_name'),
            ]);

            $attribute_category = DB::table('attribute_category')
                ->insert([
                    'category_id' => $category->id,
                    'attribute_id' => $attribute->id
                ]);

            $value = DB::table('values_of_attributes')
                ->insert([
                    'value_name' => $request->input('value_name'),
                    'attribute_id' => $attribute->id
                ]);
        });
        return redirect()->route('category.index22Admin');
    }

    public function show22Admin($id)
    {
        $category = Category::with('attributes')->where('id', '=', $id)->get();
        return view('layouts.AdminPanel.categoryAdmin.show', ['category' => $category]);
    }

    public function createCategoryAdmin(Request $request)
    {
        DB::transaction(function () use ($request) {
            $category = Category::create([
                'category_name' => $request->category,
                'category_name_ar' => $request->category_ar
            ]);

            if ($request->input('attribute')) {
                foreach ($request->input('attribute') as $attribute) {
                    $category->attributes()->attach($attribute);
                }
            }

        });
        return redirect()->route('category.index22Admin');
    }


    public function update22Admin(Request $request, Category $category)
    {


        DB::transaction(function () use ($request, $category) {
            if ($request->has("category")) {
                $category->category_name = $request->input('category');
                $category->save();
            }
            if ($request->has("category_ar")) {
                $category->category_name_ar = $request->input('category_ar');
                $category->save();
            }
            $category->attributes()->detach();
            if ($request->has("attribute")) {
                foreach ($request->input('attribute') as $attribute) {
                    $category->attributes()->attach($attribute);
                }
            }
        });
        return redirect()->route('category.index22Admin');
    }

    public function delete22Admin($id)
    {
        $category = Category::find($id)->delete();
        return redirect()->route('category.index22Admin');
    }
}
