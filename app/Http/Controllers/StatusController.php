<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Ada,Mengajar,Konsultasi,Tidak Ada',
        ]);

        $status = Status::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'status' => $request->status,
                'updated_at_iot' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui!',
            'data' => [
                'status' => $status->status,
                'updated_at' => $status->updated_at_iot->format('d M Y H:i'),
            ],
        ]);
    }

    public function show($dosenId)
    {
        $status = Status::where('user_id', $dosenId)->first();

        if (!$status) {
            return response()->json([
                'success' => true,
                'status' => 'Tidak Ada',
                'updated_at' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => $status->status,
            'updated_at' => $status->updated_at_iot->format('d M Y H:i'),
        ]);
    }
}
