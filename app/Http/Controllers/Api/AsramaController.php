<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KelasRapor;
use Illuminate\Http\JsonResponse;

class AsramaController extends Controller
{
    /**
     * Daftar semua asrama beserta wali asrama
     */
    public function index(): JsonResponse
    {
        $asrama = KelasRapor::with(['waliKelas', 'tahunAjaran'])
            ->withCount('siswas')
            ->orderBy('nama')
            ->get()
            ->map(function ($kelas) {
                return [
                    'id' => $kelas->id,
                    'nama_asrama' => $kelas->nama,
                    'tahun_ajaran' => $kelas->tahunAjaran?->tahun,
                    'wali_asrama' => $kelas->waliKelas?->nama,
                    'total_siswa' => $kelas->siswas_count,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $asrama,
        ]);
    }

    /**
     * Daftar siswa dalam asrama tertentu
     */
    public function siswa(int $id): JsonResponse
    {
        $kelas = KelasRapor::with(['waliKelas', 'tahunAjaran'])->find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'Asrama tidak ditemukan.',
            ], 404);
        }

        $siswa = $kelas->siswas()
            ->orderBy('nama')
            ->get()
            ->map(function ($s) use ($kelas) {
                return [
                    'nama' => $s->nama,
                    'nisn' => $s->nisn,
                    'tempat_lahir' => $s->tempat_lahir,
                    'tanggal_lahir' => $s->tanggal_lahir?->format('d-m-Y'),
                    'nama_asrama' => $kelas->nama,
                    'wali_asrama' => $kelas->waliKelas?->nama,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'asrama' => [
                    'id' => $kelas->id,
                    'nama' => $kelas->nama,
                    'tahun_ajaran' => $kelas->tahunAjaran?->tahun,
                    'wali_asrama' => $kelas->waliKelas?->nama,
                ],
                'siswa' => $siswa,
            ],
        ]);
    }
}
