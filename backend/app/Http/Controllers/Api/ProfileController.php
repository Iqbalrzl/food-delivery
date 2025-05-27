<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function getByUserId($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $profile = $user->profile;

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return new ProfileResource($profile);
    }


    protected function getUserFromRequest(Request $request)
    {
        $firebaseUid = $request->header('firebase_uid') ?? $request->input('firebase_uid');

        if (!$firebaseUid) {
            abort(401, 'firebase_uid is required');
        }

        $user = User::where('firebase_uid', $firebaseUid)->first();

        if (!$user) {
            abort(404, 'User not found');
        }

        return $user;
    }

    public function show(Request $request)
    {
        $user = $this->getUserFromRequest($request);

        if ($user->profile) {
            return new ProfileResource($user->profile);
        }

        $profile = new Profile(['user_id' => $user->id, 'username' => $user->email]);

        $profile->fill($request->only(['username', 'location', 'profile_image_url']));
        $profile->save();

        return new ProfileResource($profile);
    }

    public function update(Request $request)
    {
        $user = $this->getUserFromRequest($request);

        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'profile_image_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profile = $user->profile;

        if (!$profile) {
            $profile = new Profile(['user_id' => $user->id, 'username' => $user->email]);
        }

        $profile->fill($request->only(['username', 'location']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('images', $filename);
            $profile->profile_image_url = asset('storage/images/' . $filename);
        }

        $profile->save();

        return new ProfileResource($profile);

    }
}


