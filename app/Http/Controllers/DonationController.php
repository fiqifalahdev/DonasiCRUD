<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Http\Resources\DonationResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class DonationController extends Controller
{
    // Melihat semua donasi yang telah dilakukan pengguna
    public function getAllDonation()
    {
        $donation = Donation::all();

        if ($donation->isNotEmpty()) {
            return response()->json([
                'message' => 'Donasi Saya',
                'data' => new DonationResource($donation)
            ]);
        }

        return response()->json([
            'message' => "Anda belum melakukan donasi!",
        ], Response::HTTP_OK);
    } 

    // Method untuk melakukan donasi
    public function donate(Request $request)
    {
        $donate = $request->validate([
            'amount' => 'required'
        ]);

        $user = User::where('username', 'punyafiqi')->first();

        $donate['user_id'] = $user->id;
        $donate['status'] = 'selesai';

        if (Donation::create($donate)) {
            return response()->json([
                'message' => 'Donation Success',
                'data' => new DonationResource($donate)
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => "Terjadi Kesalahan",
        ], Response::HTTP_BAD_REQUEST);
    }
}
