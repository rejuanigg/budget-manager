<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function __construct(
        private CategoryService $service
    )
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $misCategorias = $request->user()->categories()->get();

        return view('categories.list-category', compact('misCategorias'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories/create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->service->store($request->validated(),Auth::id());

        return redirect()->route('categories.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        return view('categories.edit-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $this->service->update($category, $request->validated());

        return redirect()->route('categories.index')->with('exito', 'Modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        try{
            $this->service->destroy($category);

            return redirect()->route('categories.index');
        }
        catch(QueryException $qe){
            return redirect()->route('categories.index')->with('error', 'No puedes borrar una categoria que tiene transacciones asignadas.');
        };

    }
}
