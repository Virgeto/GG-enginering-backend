<?php


namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Queries\Category\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;


class CategoriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryRequest $request)
    {
        $categories = Category::getRoots();

        foreach ($categories as $category) {
            $category->translation;
        }

        return $this->response->ok($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $parentId = $request->get('parent_id');
        $translations = $request->get('translations');

        (new Store($parentId, $translations))->run();

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param $categoryId
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        $children = Category::findOrFail($categoryId)
            ->getChildren();

        foreach ($children as $child) {
            $child->translation;
        }

        return $this->response->ok($children);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
