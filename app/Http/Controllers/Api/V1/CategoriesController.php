<?php


namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Queries\Category\Show;
use App\Queries\Category\Index;
use App\Queries\Category\Store;
use App\Queries\Category\Update;
use Illuminate\Support\Facades\File;
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
        $icon = $request->file('icon');

        (new Store($parentId, $translations, $icon))->run();

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param CategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryRequest $request, $categoryId)
    {
        $input = $request->only(['with']);
        $category = (new Show($categoryId, $input))->run();

        return $this->response->ok($category);
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
        $icon = $request->file('icon');

        (new Update($categoryId, $parentId, $translations, $icon))->run();

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
        $category = Category::findOrFail($categoryId);
        $children = $category->getChildren();

        foreach ($children as $child) {
            File::deleteDirectory(public_path('images/categories/' . $child->id));
        }

        File::deleteDirectory(public_path('images/categories/' . $category->id));

        $category->deleteSubtree(true);

        return $this->response->noContent();
    }
}
