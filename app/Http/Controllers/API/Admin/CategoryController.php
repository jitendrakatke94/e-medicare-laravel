<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     *
     * @group General
     *
     * List Category
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam paginate nullable integer nullable paginate = 0
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "parent_id": null,
     *            "name": "Para"
     *        },
     *        {
     *            "id": 2,
     *            "parent_id": 1,
     *            "name": "Paracita"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/category?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/category?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/category",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 2,
     *    "total": 2
     *}
     * @response 200 [
     *    {
     *        "id": 1,
     *        "parent_id": null,
     *        "name": "Para"
     *    },
     *    {
     *        "id": 2,
     *        "parent_id": 1,
     *        "name": "Paracita"
     *    }
     *]
     * @response 404 {
     *    "message": "Categories not found"
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);
        if ($request->filled('paginate')) {
            $list = Category::all();
        } else {
            $list = Category::orderBy('id', 'desc')->paginate(Category::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("Categories not found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin add category
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam parent_id integer nullable id of category
     * @bodyParam name string required unique
     * @bodyParam image file nullable mimes:jpg,jpeg,png max:2mb
     *
     * @response 200 {
     *    "message": "Category added successfully."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "parent_id": [
     *            "The selected parent id is invalid."
     *        ],
     *        "name": [
     *            "The name field is required."
     *        ]
     *    }
     *}
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/category';
            $filePath = $request->file('image')->storeAs($folder, time() . $fileName);
            $data['image_path'] = $filePath;
        }
        Category::create($data);
        return new SuccessMessage('Category added successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin edit Category by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @bodyParam name string required unique
     * @bodyParam image file nullable mimes:jpg,jpeg,png max:2mb
     *
     * @response 404 {
     *    "message": "Category not found."
     *}
     * @response 200 {
     *    "message": "Category updated successfully."
     *}
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (\Exception $exception) {

            return new ErrorMessage('Category not found.', 404);
        }
        $data = $request->validated();
        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/category';
            $filePath = $request->file('image')->storeAs($folder, time() . $fileName);
            $data['image_path'] = $filePath;
        }
        $data['updated_by'] = auth()->user()->id;
        $category->update($data);
        return new SuccessMessage('Category updated successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin delete Category by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 403 {
     *    "message": "This category has several medicines. You must make sure this category is empty before deleting it."
     *}
     * @response 200 {
     *    "message": "Category deleted successfully."
     *}
     * @response 404 {
     *    "message": "Category not found."
     *}
     */
    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->parent()->exists() || $category->medicine()->exists()) {
                return new ErrorMessage('This category has several medicines. You must make sure this category is empty before deleting it.', 403);
            }
            $category->delete();
            return new SuccessMessage('Category deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Category not found.', 404);
        }
    }
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin search Category by name
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam name required string
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "name": "Para"
     *    },
     *    {
     *        "id": 3,
     *        "name": "Dolo"
     *    }
     *]
     * @response 404 {
     *    "message": "Category not found."
     *}
     */
    public function search(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        $category = Category::where('name', 'like', '%' . $data['name'] . '%')->get();

        if ($category->count() > 0) {
            $category->makeHidden('parent_id');
            return response()->json($category, 200);
        }
        return new ErrorMessage('Category not found.', 404);
    }
}
