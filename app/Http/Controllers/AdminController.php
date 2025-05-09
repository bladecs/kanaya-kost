<?php

namespace App\Http\Controllers;

use App\Models\RoomModels;
use App\Models\FacilityModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Menampilkan semua kamar
    public function index()
    {
        $rooms = RoomModels::with('facilities')->get();
        $customer = User::where('role', 'customer')->get();
        return view('admin.dashboard', compact('rooms','customer'));
    }

    // Menyimpan kamar baru (dari modal)
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'room_name' => 'required|string|max:255|unique:rooms,nama',
                'room_price' => 'required|numeric',
                'room_status' => 'required|string',
                'facilities' => 'nullable|array',
                'facilities.*' => 'in:ac,kamar_mandi,tv,lemari,kursi,meja',
                'description' => 'nullable|string'
            ]);

            // Konversi status ke available (boolean)
            $roomStatus = $request->room_status === 'true' ? true : false;
            // Buat kamar baru
            $room = RoomModels::create([
                'nama' => $validated['room_name'],
                'price' => $validated['room_price'],
                'available' => $roomStatus,
                'lantai' => '1', // Default lantai, bisa diubah sesuai kebutuhan
                'rating' => null,
                'description' => $request->description ?? null,
            ]);

            // Simpan fasilitas (jika menggunakan relasi many-to-many)
            if (isset($validated['facilities'])) {
                // Cari atau buat fasilitas
                $facilityIds = [];
                foreach ($validated['facilities'] as $facilitySlug) {
                    $facility = FacilityModel::firstOrCreate(
                        ['name' => ucfirst(str_replace('_', ' ', $facilitySlug))]
                    );
                    $facilityIds[] = $facility->id;
                }

                $room->facilities()->sync($facilityIds);
            }

            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'success',
                    'message' => 'Kamar berhasil ditambahkan!'
                ])->with('activeTab', 'rooms');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ])->with('activeTab', 'rooms');
        }
    }
    // Update kamar
    public function update(Request $request)
    {
        Log::info($request->all());
        try {
            $room = RoomModels::findOrFail($request->room_id);

            $validated = $request->validate([
                'room_name' => 'required|string|max:255',
                'room_price' => 'required|numeric',
                'room_status' => 'required|string',
                'facilities' => 'nullable|array',
                'facilities.*' => 'exists:facilities,id',
                'description' => 'nullable|string'
            ]);

            // Konversi string 'false' ke boolean
            $roomStatus = $request->room_status === 'true' ? true : false;

            $room->update([
                'nama' => $validated['room_name'],
                'price' => $validated['room_price'],
                'available' => $roomStatus,
                'description' => $validated['description']
            ]);

            // Sync langsung IDs fasilitas
            $room->facilities()->sync($validated['facilities'] ?? []);

            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'success',
                    'message' => 'Kamar berhasil diupdate!'
                ])->with('activeTab', 'rooms');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'error',
                    'message' => 'Gagal update: ' . $e->getMessage()
                ])->with('activeTab', 'rooms');
        }
    }
    // Hapus kamar
    public function destroy(Request $request)
    {
        try {
            $room = RoomModels::findOrFail($request->room_id);
            $room->facilities()->detach();
            $room->delete();

            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'success',
                    'message' => 'Kamar berhasil dihapus!'
                ])->with('activeTab', 'rooms');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'error',
                    'message' => 'Gagal update: ' . $e->getMessage()
                ])->with('activeTab', 'rooms');
        }
    }
}
