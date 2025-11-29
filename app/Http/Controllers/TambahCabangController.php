<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TambahCabangController extends Controller
{
    // ✅ Tampilkan halaman tambah cabang
    public function index()
    {
        $cabangs = Cabang::all();
        return view('admin.tambahcabang', compact('cabangs'));
    }

    // ✅ Simpan cabang baru + akun admin cabang
    public function store(Request $request)
    {
        $loginColumn = Schema::hasColumn('users', 'username') ? 'username' : 'name';

        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', $loginColumn),
            ],
            'password' => 'required|string|min:8',
        ]);

        try {
            DB::transaction(function () use ($validated, $loginColumn) {
                $cabang = Cabang::create([
                    'nama_cabang' => $validated['nama_cabang'],
                    'lokasi' => $validated['lokasi'],
                ]);

                $username = $validated['username'];
                $email = $this->generateCabangEmail($username);

                $userData = [
                    'password' => Hash::make($validated['password']),
                    'role' => 'cabang',
                    'cabang_id' => $cabang->id,
                ];

                if ($loginColumn === 'username') {
                    $userData['name'] = 'Admin ' . $validated['nama_cabang'];
                    $userData['username'] = $username;
                } else {
                    $userData['name'] = $username;
                }

                if ($email !== null) {
                    $userData['email'] = $email;
                }

                User::create($userData);
            });
        } catch (\Throwable $th) {
            // DB::rollback() sebenarnya otomatis dilakukan jika pakai DB::transaction,
            // tapi tidak ada salahnya dibiarkan jika manual.

            // --- GANTI BAGIAN INI ---
            return redirect()->route('tambahcabang.index')
                ->with('error', 'SYSTEM ERROR: ' . $th->getMessage());
            // ------------------------
        }


        return redirect()->route('tambahcabang.index')
        ->with('success', 'Cabang berhasil ditambahkan!');



    }

    // ✅ Update cabang
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        try {
            $cabang = Cabang::findOrFail($id);
            $cabang->update([
                'nama_cabang' => $validated['nama_cabang'],
                'lokasi' => $validated['lokasi'],
            ]);

            return redirect()->route('tambahcabang.index')
                ->with('success', 'Cabang berhasil diperbarui!');
            } catch (\Exception $e) {
                DB::rollback();
                // Tampilkan pesan error asli dari Laravel/Database
                return redirect()->back()->with('error', 'Error System: ' . $e->getMessage());
            }
    }

    // ✅ Hapus cabang
    public function destroy($id)
    {
        try {
            $cabang = Cabang::findOrFail($id);
            $cabang->delete();

            return redirect()->route('tambahcabang.index')
                ->with('success', 'Cabang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('tambahcabang.index')
                ->with('error', 'Gagal menghapus cabang');
        }
    }

    private function generateCabangEmail(string $username): ?string
    {
        if (!Schema::hasColumn('users', 'email')) {
            return null;
        }

        $base = Str::slug($username, '_') ?: 'cabang';
        $domain = 'cabang.lafleur.local';
        $email = "{$base}@{$domain}";
        $counter = 1;

        while (User::where('email', $email)->exists()) {
            $email = "{$base}_{$counter}@{$domain}";
            $counter++;
        }

        return $email;
    }
}

