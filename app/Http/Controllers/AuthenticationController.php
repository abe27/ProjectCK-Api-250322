<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    private $sub = "Authenticate";
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'empcode' => ['required', 'string', 'min:5', 'max:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($v->fails()) {
            return [
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => $v
            ];
        }

        $user = User::create([
            'name' => $request->name,
            'empcode' => $request->empcode,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // write log
        LogActivity::addToLog($this->sub,'ลงทะเบียนผู้ใช้งานใหม่');
        return response()->json([
            'success' => true,
            'message' => $v->getMessageBag(),
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    public function login(Request $request)
    {
        // return response()->json($request->all());

        if (!Auth::attempt($request->only('empcode', 'password'))) {
            return response()->json([
                'success' => false,
                'token' => null,
                'access' => null,
                'message' => 'ไม่พบข้อมูลผู้ใช้งาน',
                'profiles' => []
            ], 401);
        }

        $user = User::where('empcode', $request['empcode'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        $profiles = User::with(
            'data',
            'data.factory',
            'data.whs',
            'territory',
            'territory.consignee',
            'territory.consignee.factory',
            'territory.consignee.aff',
            'territory.consignee.customer',
            'territory.consignee.region',
            'territory.consignee.address',
            'territory.zone_type',
            'territory.shipping',
        )->find($user->id);
        // log
        LogActivity::addToLog($this->sub,'เข้าสู่ระบบ');

        return response()->json([
            'success' => true,
            'token' => $token,
            'access' => 'Bearer',
            'message' => 'ยินดีต้อนรับเข้าสู่ระบบ CWS',
            'profiles' => $profiles
        ], 200);
    }

    public function me(Request $request)
    {
        LogActivity::addToLog($this->sub,'ตรวจสอบข้อมูลส่วนตัว');
        return $request->user();
    }

    public function destroy(Request $request) {
        LogActivity::addToLog($this->sub,'ออกจากระบบ');
        return response()->json([
            'success' => $request->user()->currentAccessToken()->delete(),
            'token' => null,
            'access' => 'Bearer',
            'message' => 'ออกจากระบบเรียบร้อยแล้ว'
        ], 200);
    }
}
