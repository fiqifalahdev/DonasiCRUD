<?php

namespace App\Http\Controllers;

use App\Http\Resources\RaiseFundResource;
use App\Models\RaiseFund;
use App\Models\Receiver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;

class RaiseFundController extends Controller
{
    // Melihat semua galangdana yang telah dibuat
    public function getAllRaiseFund()
    {
        $raiseFund = RaiseFund::all();

        if ($raiseFund->isNotEmpty()) {
            return response()->json([
                'message' => 'Galang Dana Anda',
                'data' => new RaiseFundResource($raiseFund)
            ]);
        }

        return response()->json([
            'message' => "Tidak Ada Galang Dana yang aktif",
        ], Response::HTTP_OK);
    }  

    // Membuat sebuah galangdana
    public function createRaiseFund(Request $request)
    {
        $request['closed_funds'] = Date::now();

        $raiseFundData = $request->validate([
            'title' => 'required',
            'links' => 'required',
            'funds' => 'required',
            'closed_funds' => 'required',
            'details_funds' => 'required',
        ]);

        $receiverData = $request->validate([
            'receiverName' => 'required',
            'purpose' => 'required',
            'location' => 'required',
        ]);

        // Bisa diganti sesuai dengan user yang terautentikasi 
        $user = User::where('username', 'punyafiqi')->first();
        $raiseFundData['user_id'] = $user->id;

        $receive = Receiver::create($receiverData);
        $raiseFundData['receiver_id'] = $receive->id;

        $raiseFund = RaiseFund::create($raiseFundData);

        if ($raiseFund) {
            return response()->json([
                'message' => 'Galang Dana sudah dibuat!',
                'data' => new RaiseFundResource($raiseFund)
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => "Terjadi Kesalahan",
        ], Response::HTTP_BAD_REQUEST);
    }

    // Melihat detail dari suatu galang dana
    public function showRaiseFund(RaiseFund $raiseFund)
    {
        return response()->json([
            'message' => $raiseFund->title,
            'data' => new RaiseFundResource($raiseFund)
        ], Response::HTTP_OK);
    }

    // update galangdana
    public function updateRaiseFund(Request $request, RaiseFund $raiseFund)
    {
        $request['closed_funds'] = Date::now();

        $raiseFundData = $request->validate([
            'title' => 'required',
            'links' => 'required',
            'funds' => 'required',
            'closed_funds' => 'required',
            'details_funds' => 'required',
        ]);

        $receiverData = $request->validate([
            'receiverName' => 'required',
            'purpose' => 'required',
            'location' => 'required',
        ]);

        $receiver = Receiver::find($raiseFund->receiver_id);
        $receiver->update($receiverData);

        $update = $raiseFund->update($raiseFundData);

        if ($update) {
            return response()->json([
                'message' => 'Edit Galang Dana Selesai!',
                'data' => new RaiseFundResource($raiseFund)
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => "Terjadi Kesalahan",
        ], Response::HTTP_BAD_REQUEST);
    }

    // Menghapus galangdana
    public function deleteRaiseFund(RaiseFund $raiseFund)
    {
        $deleteRaiseFund = $raiseFund->delete();
        $receiver = Receiver::where("id", $raiseFund->receiver_id)->first();
        $receiver->delete();
        
        if ($deleteRaiseFund) {
            return response()->json([
                'message' => "Galang Dana Berhasil dihapus!",
                'data' => new RaiseFundResource($raiseFund)
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => "Terjadi Kesalahan",
        ], Response::HTTP_BAD_REQUEST);
    }
}
