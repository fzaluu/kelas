<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SystemSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name'           => config('app.name', 'XI PPLG 2'),
            'system_alert'       => Cache::get('system_alert_message', ''),
            'alert_status'       => Cache::get('system_alert_status', 'DISABLED'),
            'maintenance_mode'   => Cache::get('system_maintenance_mode', 'OFF'),
            'attendance_open'    => Cache::get('attendance_open_time', '06:30'),
            'attendance_close'   => Cache::get('attendance_close_time', '07:30'),
        ];

        return view('pages.development.system.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'system_alert'     => ['nullable', 'string', 'max:500'],
            'alert_status'     => ['required', 'in:ENABLED,DISABLED'],
            'maintenance_mode' => ['required', 'in:ON,OFF'],
            'attendance_open'  => ['required'],
            'attendance_close' => ['required'],
        ]);

        Cache::forever('system_alert_message', $request->system_alert);
        Cache::forever('system_alert_status', $request->alert_status);
        Cache::forever('system_maintenance_mode', $request->maintenance_mode);
        Cache::forever('attendance_open_time', $request->attendance_open);
        Cache::forever('attendance_close_time', $request->attendance_close);

        return redirect()->route('development.system.settings.index')
            ->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }
}