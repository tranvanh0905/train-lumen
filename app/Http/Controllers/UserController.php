<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function authenticate(Request $request) {
        $this->validate($request, [
            'username'      => 'required',
            'password_hash' => 'required',
        ]);
        $user = User::where('username', $request->input('username'))->first();
        if ($user !== null) {
            if (Hash::check($request->input('password_hash'), $user->password_hash)) {
                $apikey = base64_encode(User::generateRandomString(40));
                User::where('username', $request->input('username'))->update(['api_key' => "$apikey"]);
                return response()->json([
                    'status'  => 'success',
                    'api_key' => $apikey,
                ]);
            } else {
                return response()->json(['status' => 'fail'], 401);
            }
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }
}
