<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptHelper;
use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    public function encrypt(Request $request)
    {
        $key = $request->bearerToken();
        return response()->json(['encrypted' => EncryptHelper::encrypt($request->all(), $key)]);
    }

    public function decrypt(Request $request)
    {
        $key = $request->bearerToken();
        return response()->json(['decrypted' => EncryptHelper::decrypt($request->all()[0], $key)]);
    }
}
