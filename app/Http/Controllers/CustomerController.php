<?php

namespace App\Http\Controllers;

use App\Models\FacilityModel;
use App\Models\User;
use App\Models\RoomModels;
use App\Models\PaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
    public function rooms()
    {
        $available_rooms = RoomModels::where('available', 0)->count();
        return view('dashboard.detail-room', compact('available_rooms'));
    }
    public function profile(Request $request)
    {
        $previous_url = $request->query('previous');
        $user = User::where('id', Auth::id())->first();
        $payment = PaymentModel::where('user_id', $user->id)->first();
        $payments = PaymentModel::where('user_id', $user->id)->get();
        $room = RoomModels::where('tenant', $user->id)->first();
        $rooms = RoomModels::where('tenant', $user->id)->get();
        return view('dashboard.profile', compact('user', 'previous_url', 'payment', 'payments', 'room', 'rooms'));
    }
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payment,id',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $payment = PaymentModel::findOrFail($request->payment_id);

            // Handle file upload
            $file = $request->file('bukti_pembayaran');
            $fileName = 'payment_' . $payment->id . '_' . time() . '.' . $file->extension();
            $path = $file->storeAs('public/payments', $fileName);

            // Simpan data sebelum update untuk pengecekan
            $originalData = $payment->getOriginal();

            // Update database
            $updated = $payment->update([
            'payment_proof' => 'payments/' . $fileName,
            'status' => 'pending_verification',
            'notes' => $request->catatan,
            'verified_at' => null,
            ]);

            if (!$updated) {
            throw new \Exception("Gagal mengupdate data pembayaran");
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui dan menunggu verifikasi.');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($path)) {
            Storage::delete($path);
            }

            return redirect()->back()->with('error', 'Gagal memperbarui pembayaran: ' . $e->getMessage());
        }
    }
}
