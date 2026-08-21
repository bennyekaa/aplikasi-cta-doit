<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class SyncTargetKelulusan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:target-kelulusan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ambil target kelulusan dari web service ke tabel lokal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memeriksa tabel temp_target_kelulusan...');
        
        // Buat tabel jika belum ada
        if (!Schema::hasTable('temp_target_kelulusan')) {
            Schema::create('temp_target_kelulusan', function (Blueprint $table) {
                $table->id();
                $table->string('nama_user')->index(); // index supaya pencarian cepat
                $table->integer('nilai_target')->default(0);
                $table->timestamps();
            });
            $this->info('Tabel temp_target_kelulusan berhasil dibuat.');
        }

        // Mengambil URL web service dari .env, default: https://gist.githubusercontent.com/bennyekaa/c93e1480197040ea2d0baa15e074086a/raw
        $webServiceUrl = env('TARGET_API_URL', 'https://gist.githubusercontent.com/bennyekaa/c93e1480197040ea2d0baa15e074086a/raw');

        try {
            $response = Http::withoutVerifying()->timeout(10)->get($webServiceUrl);
            
            if ($response->successful()) {
                $data = $response->json(); // Format: [['nama' => 'Budi', 'nilai' => 85], ...]
                
                if (is_array($data) && count($data) > 0) {
                    DB::table('temp_target_kelulusan')->truncate(); // Bersihkan data lama
                    
                    foreach ($data as $item) {
                        if (isset($item['nama']) && isset($item['nilai'])) {
                            DB::table('temp_target_kelulusan')->insert([
                                'nama_user'    => $item['nama'],
                                'nilai_target' => $item['nilai'],
                                'created_at'   => now(),
                                'updated_at'   => now()
                            ]);
                        }
                    }
                    $this->info('Berhasil menyinkronkan data target kelulusan (' . count($data) . ' data).');
                } else {
                    $this->info('Web service merespons, namun data target kelulusan kosong.');
                }
            } else {
                $this->error('Gagal mengambil data dari Web Service! Status: ' . $response->status());
            }
        } catch (\Exception $e) {
            $this->error('Error saat mengambil data: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
