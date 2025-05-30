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
        $customer = User::with('rooms')->where('role', 'customer')->get();
        $customerCount = $customer->count();
        $roomCount = $rooms->count();
        $avaliableRoomCount = $rooms->where('available', true)->count();
        return view('admin.dashboard', compact('rooms', 'customer', 'customerCount', 'roomCount', 'avaliableRoomCount'));
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
    public function payment()
    {
        $payments = PaymentModel::with(['user', 'room'])->get();

        return response()->json([
            'success' => true,
            'payments' => $payments,
        ]);
    }

    public function verify_payment($payment_id)
    {
        try {
            $payment = PaymentModel::findOrFail($payment_id);
            $payment->status = 'paid';
            $payment->verified_at = now();
            $payment->verified_by = auth()->id();
            $payment->save();

            User::where('id', $payment->user_id)->update(['status' => 'active']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diverifikasi!',
                'payment' => $payment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi pembayaran: ' . $e->getMessage()
            ]);
        }
    }

    public function checkLatePayments()
    {
        $latePayments = PaymentModel::with(['user', 'room'])
            ->whereIn('status', ['pending', 'late'])
            ->where('periode', '<', now()->startOfMonth())
            ->get();

        foreach ($latePayments as $payment) {
            $payment->update(['status' => 'late']);

            // Optional: Nonaktifkan user jika pembayaran terlambat
            User::where('id', $payment->user_id)->update(['status' => 'non-active']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Late payments checked',
            'count' => $latePayments->count()
        ]);
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
