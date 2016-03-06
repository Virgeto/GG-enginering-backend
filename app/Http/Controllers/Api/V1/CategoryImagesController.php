<?php


namespace App\Http\Controllers\Api\V1;

use App\CategoryImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryImageRequest;
use Illuminate\Support\Facades\File;


class CategoryImagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param CategoryImageRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryImageRequest $request, $categoryId)
    {
        $categoryImages = CategoryImage::where('category_id', $categoryId)
            ->paginate();

        return $this->response->ok($categoryImages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryImageRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryImageRequest $request, $categoryId)
    {
        $images = $request->file('images');

        foreach ($images as $image) {
            $categoryImage = new CategoryImage(['name' => $image->getClientOriginalName()]);
            $categoryImage->category()->associate($categoryId);
            $categoryImage->save();

            $path = public_path('images/categories/' . $categoryId);
            $filename = $image->getClientOriginalName();
            $image->move($path, $filename);
        }

        return $this->response->created();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryImageRequest $request
     * @param $categoryId
     * @param $categoryImageId
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryImageRequest $request, $categoryId, $categoryImageId)
    {
        $categoryImage = CategoryImage::findOrFail($categoryImageId);
        $categoryImage->delete();

        $parts = explode('/', $categoryImage->name);
        $imageName = last($parts);
        $path = public_path('images/categories/' . $categoryId . '/' . $imageName);
        File::delete($path);

        return $this->response->noContent();
    }
}
