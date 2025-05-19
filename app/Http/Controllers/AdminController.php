<?php

namespace App\Http\Controllers;

use App\Models\RoomModels;
use App\Models\FacilityModel;
use App\Models\PaymentModel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $rooms = RoomModels::with('facilities')->get();
        $customer = User::where('role', 'customer')->get();
        $customerCount = $customer->count();
        $roomCount = $rooms->count();
        $payments = PaymentModel::with(['user', 'room'])->get();
        $avaliableRoomCount = $rooms->where('available', true)->count();
        return view('admin.dashboard', compact('rooms', 'customer','payments', 'customerCount', 'roomCount', 'avaliableRoomCount'));
    }

    // Room Function
    // Penyimpanan Room
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
            // $tenant = User::all(); // Tidak perlu mengambil semua user
            $validated = $request->validate([
                'room_name' => 'required|string|max:255',
                'room_price' => 'required|numeric',
                'room_status' => 'required|string',
                'tenant' => 'nullable|exists:users,id',
                'facilities' => 'nullable|array',
                'facilities.*' => 'exists:facilities,id',
                'description' => 'nullable|string'
            ]);

            // Konversi string 'false' ke boolean

            $room->update([
                'nama' => $validated['room_name'],
                'price' => $validated['room_price'],
                'tenant' => $validated['tenant'],
                'available' => $validated['room_status'],
                'description' => $validated['description']
            ]);

            if ($validated['room_status'] == 1) {
                User::where('id', $validated['tenant'])->update([
                    'status' => true
                ]);
                $room->update([
                    'tenant' => $validated['tenant']
                ]);
                PaymentModel::create([
                    'id' => 'INV-' . $validated['tenant'] . '-' . date('mY'),
                    'user_id' => $validated['tenant'],
                    'room_id' => $room->id,
                    'amount' => $validated['room_price'],
                    'periode' => now()->addMonth(),
                    'status' => 'pending',
                    'payment_proof' => null,
                ]);
            } else {
                User::where('id', $validated['tenant'])->update([
                    'status' => false
                ]);
                $room->update([
                    'tenant' => null
                ]);
            }

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

    // Payment Function
    public function payment(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_status' => 'required|string',
                'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Simpan bukti pembayaran
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/payment_proofs', $file, $filename);
            }

            // Update status pembayaran
            PaymentModel::where('id', $request->message_id)->update([
                'status' => $validated['payment_status'],
                'payment_proof' => isset($filename) ? 'storage/payment_proofs/' . $filename : null,
            ]);

            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'success',
                    'message' => 'Pembayaran berhasil diproses!'
                ])->with('activeTab', 'payments');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('notification', [
                    'type' => 'error',
                    'message' => 'Gagal update: ' . $e->getMessage()
                ])->with('activeTab', 'payments');
        }
    }

    public function user()
    {
        $users = User::where('role', 'customer')->select('id', 'name')->get();
        return response()->json([
            'data' => $users,
            'message' => 'Data user berhasil diambil'
        ])->setStatusCode(200);
    }
}
