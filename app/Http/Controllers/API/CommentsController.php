<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    /**
     * @authenticated
     *
     * @group General
     *
     * List comment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam paginate nullable integer paginate = 0
     * @queryParam to_user_id nullable integer id of to_user

     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "comment": "First comment",
     *            "to_user": {
     *                "id": 3,
     *                "first_name": "Test",
     *                "middle_name": null,
     *                "last_name": "Patient",
     *                "profile_photo_url": null
     *            },
     *            "from_user": {
     *                "id": 15,
     *                "first_name": "Walker",
     *                "middle_name": "Kimberly",
     *                "last_name": "S",
     *                "profile_photo_url": null
     *            }
     *        },
     *        {
     *            "id": 2,
     *            "comment": "Send comment",
     *            "to_user": {
     *                "id": 3,
     *                "first_name": "Test",
     *                "middle_name": null,
     *                "last_name": "Patient",
     *                "profile_photo_url": null
     *            },
     *            "from_user": {
     *                "id": 15,
     *                "first_name": "Walker",
     *                "middle_name": "Kimberly",
     *                "last_name": "S",
     *                "profile_photo_url": null
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/comments?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/comments?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/comments",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 2,
     *    "total": 2
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
            'to_user_id' => 'nullable|exists:users,id',
        ]);
        $list = Comments::query();
        if ($request->filled('to_user_id')) {

            $list = $list->where('to_user_id', $request->to_user_id)->where('from_user_id', auth()->user()->id)->with('to_user:id,first_name,middle_name,last_name')->with('from_user:id,first_name,middle_name,last_name');
        } else {
            $list = $list->where('to_user_id', auth()->user()->id)->with('from_user:id,first_name,middle_name,last_name');
        }

        if ($request->filled('paginate')) {
            $list = $list->get();
        } else {
            $list = $list->paginate(Comments::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Add comment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam to_id integer required id of to_user
     * @bodyParam comment string nullable present
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "to_user_id": [
     *            "The selected to user id is invalid."
     *        ],
     *        "comment": [
     *            "The comment field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Comment created successfully."
     *}
     */
    public function create(CommentRequest $request)
    {
        $data = $request->validated();
        $data['from_user_id'] = auth()->user()->id;
        Comments::create($data);
        return new SuccessMessage('Comment created successfully.', 200);
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Delete comment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 404 {
     *    "message": "Comment not found."
     *}
     * @response 200 {
     *    "message": "Comment deleted successfully."
     *}
     */
    public function destroy($id)
    {
        try {
            $comments = Comments::findOrFail($id);
        } catch (\Exception $exception) {
            return new ErrorMessage('Comment not found.', 404);
        }
        $comments->destroy($id);
        return new SuccessMessage('Comment deleted successfully.');
    }
}
