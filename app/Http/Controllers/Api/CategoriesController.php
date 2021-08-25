<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    use GeneralTrait;
    
    public function index()
    {
        $categories = Category::selection()->get();

        !$categories ?  $response = $this->onError() : $response = $this->onSuccess('category', $categories);
        
        return $response;
    }

    public function getCategoryById(Request $request)
    {
        $category = Category::selection()->find($request->id);

        !$category ?  $response = $this->onError() : $response = $this->onSuccess('category', $category);
        
        return $response;
    }

    public function changeCategoryStatus(Request $request)
    {
        
        Category::where('id', $request->id)->update(['status' => $request->status]);

        $category = Category::selection()->find($request->id);

        !$category ?  $response = $this->onError() : $response = $this->onSuccess('category', $category, 'Category Updated Successfully');
        
        return $response;
    }
}
