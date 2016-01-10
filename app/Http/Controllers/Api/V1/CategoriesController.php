<?php


namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Queries\Category\Show;
use App\Queries\Category\Index;
use App\Queries\Category\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Queries\Category\Update;


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
        $categories = (new Index())->run();

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
        $children = (new Show($categoryId))->run();

        return $this->response->ok($children);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $categoryId)
    {
        $parentId = $request->get('parent_id');
        $translations = $request->get('translations');

        (new Update($categoryId, $parentId, $translations))->run();

        return $this->response->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryRequest $request, $categoryId)
    {
        Category::findOrFail($categoryId)->delete();

        return $this->response->noContent();
    }
}
