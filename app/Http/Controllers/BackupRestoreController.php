<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Exception;

class BackupRestoreController extends Controller
{
    public function index()
    {
        return view('backup_restore.index');
    }

    public function backup()
    {
        try {
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');
            $port = env('DB_PORT', '3306');

            // Detect if running in portable build or local environment
            // In portable, mysql is located in ../mysql/bin/mysqldump.exe relative to app folder
            $portableMysqlDumpPath = base_path('../mysql/bin/mysqldump.exe');
            $mysqlDumpCmd = 'mysqldump'; // Default system path

            if (file_exists($portableMysqlDumpPath)) {
                $mysqlDumpCmd = '"' . $portableMysqlDumpPath . '"';
            }

            $fileName = 'backup_' . $database . '_' . date('Y_m_d_H_i_s') . '.sql';
            $backupPath = storage_path('app/' . $fileName);

            $passwordOption = $password ? "-p{$password}" : "";
            $command = "{$mysqlDumpCmd} --user={$username} {$passwordOption} --host={$host} --port={$port} {$database} > \"{$backupPath}\"";
            
            // Fix for empty password in windows command line sometimes causing issues
            if(empty($password)){
                $command = "{$mysqlDumpCmd} --user={$username} --host={$host} --port={$port} {$database} > \"{$backupPath}\"";
            }

            exec($command . ' 2>&1', $output, $returnVar);

            if ($returnVar !== 0) {
                return back()->with('error', 'Gagal melakukan backup database. ' . implode("\n", $output));
            }

            return response()->download($backupPath)->deleteFileAfterSend(true);

        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat backup: ' . $e->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimetypes:text/plain,application/sql,text/x-sql|max:50000',
        ], [
            'backup_file.required' => 'Pilih file backup (.sql) terlebih dahulu.',
            'backup_file.file' => 'File tidak valid.',
            'backup_file.mimetypes' => 'File harus berekstensi .sql',
        ]);

        try {
            $file = $request->file('backup_file');
            $sqlContents = file_get_contents($file->getRealPath());

            // Disable foreign key checks for restore
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Execute the raw SQL
            DB::unprepared($sqlContents);
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return back()->with('success', 'Database berhasil direstore.');
        } catch (Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Make sure to re-enable on error
            return back()->with('error', 'Gagal melakukan restore: ' . $e->getMessage());
        }
    }
}
