<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requests\StoreCategoryRequest;
use App\Http\Requests\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $service
    ){}

    public function index(Request $request)
    {
        $misCategorias = $request->user()->categories()->get();

        return CategoryResource::collection($misCategorias);
    }

    public function store(StoreCategoryRequest $request)
    {
        $newCategory = $this->service->store($request->validated(), Auth::id());

        $resource = new CategoryResource($newCategory);

        return $resource->response()->setStatusCode(201);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $editarCategoria = $this->service->update($category, $request->validated());

        $resource = new CategoryResource(($editarCategoria));

        return $resource->response()->setStatusCode(200);
    }

    public function destroy(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $this->service->destroy($category);

        return response()->noContent();
    }
}
