<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller {

    /**
     * TaskController constructor.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request) {
        $task = Task::where('user_id', $request->input('userid'))->get();
        return response()->json([
            'status' => 'success',
            'result' => $task,
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function view(Request $request, $id) {
        $task = Task::where('user_id', $request->input('userid'))->where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'result' => $task,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request) {
        $this->validate($request, [
            'content' => 'required',
        ]);
        $task          = new Task();
        $task->user_id = $request->input("userid");
        $task->content = $request->input('content');
        if ($task->save()) {
            $job = new SendMailJob($task);
            $this->dispatch(($job));
            return response()->json([
                'status' => 'success',
                'result' => $task,
            ]);
        }
        return response()->json([
            'status' => "error",
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id) {
        $task = Task::where('user_id', $request->input('userid'))->where('id', $id)->first();
        if ($task !== null) {
            $task->content = $request->input('content');
            if ($task->save()) {
                return response()->json([
                    'status' => 'success',
                    'result' => $task,
                ]);
            }
            return response()->json([
                'status' => 'error',
            ]);
        };
        return response()->json([
            'status' => 'error',
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function delete(Request $request, $id) {
        $task = Task::where('user_id', $request->input('userid'))->where('id', $id)->first();
        if ($task !== null && $task->delete()) {
            return response()->json([
                'status' => 'success',
                'result' => "Delete Complete",
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);
    }
}
