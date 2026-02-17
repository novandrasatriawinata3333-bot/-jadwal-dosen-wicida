<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function show($dosenId)
    {
        $status = Status::where('user_id', $dosenId)->first();
        
        return response()->json($status ?? ['status' => 'Tidak Ada']);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Ada,Tidak Ada,Rapat,Mengajar',
        ]);

        Status::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'status' => $validated['status'],
                'last_updated' => now(),
            ]
        );

        return response()->json(['message' => 'Status berhasil diupdate!']);
    }

    public function iotUpdate(Request $request)
    {
        // Validasi IoT token (tambahkan sesuai kebutuhan)
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Ada,Tidak Ada,Rapat,Mengajar',
            'token' => 'required|string', // IoT device token
        ]);

        // TODO: Validasi token IoT di sini
        
        Status::updateOrCreate(
            ['user_id' => $validated['user_id']],
            [
                'status' => $validated['status'],
                'last_updated' => now(),
            ]
        );

        return response()->json(['message' => 'Status updated from IoT device']);
    }

    public function getAllStatus()
    {
        $statuses = Status::with('user:id,name,email')->get();
        
        return response()->json($statuses);
    }
}
