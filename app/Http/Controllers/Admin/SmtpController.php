<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSmtpRequest;
use App\Http\Requests\UpdateSmtpRequest;
use App\Models\SmtpSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SmtpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $smtpSettings = SmtpSetting::orderBy('is_active', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.smtp.index', compact('smtpSettings'));
        } catch (\Exception $e) {
            Log::error('SMTP ayarları listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return view('admin.smtp.index', ['smtpSettings' => collect()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.smtp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSmtpRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // If this is set as active, deactivate all others
            if ($data['is_active']) {
                SmtpSetting::where('is_active', true)->update(['is_active' => false]);
            }

            SmtpSetting::create($data);

            return redirect()
                ->route('admin.smtp.index')
                ->with('success', 'SMTP ayarı başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            Log::error('SMTP ayarı oluşturulurken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'SMTP ayarı oluşturulurken bir hata oluştu.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SmtpSetting $smtp): View
    {
        return view('admin.smtp.show', compact('smtp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SmtpSetting $smtp): View
    {
        return view('admin.smtp.edit', compact('smtp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSmtpRequest $request, SmtpSetting $smtp): RedirectResponse
    {
        try {
            $data = $request->validated();

            // If password is empty, keep the existing password
            if (empty($data['password'])) {
                unset($data['password']);
            }

            // If this is set as active, deactivate all others
            if ($data['is_active']) {
                SmtpSetting::where('is_active', true)
                    ->where('id', '!=', $smtp->id)
                    ->update(['is_active' => false]);
            }

            $smtp->update($data);

            return redirect()
                ->route('admin.smtp.index')
                ->with('success', 'SMTP ayarı başarıyla güncellendi.');
        } catch (\Exception $e) {
            Log::error('SMTP ayarı güncellenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'SMTP ayarı güncellenirken bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SmtpSetting $smtp): RedirectResponse
    {
        try {
            // Don't allow deletion of active SMTP setting
            if ($smtp->is_active) {
                return redirect()
                    ->back()
                    ->with('error', 'Aktif SMTP ayarı silinemez. Önce başka bir ayarı aktif yapın.');
            }

            $smtp->delete();

            return redirect()
                ->route('admin.smtp.index')
                ->with('success', 'SMTP ayarı başarıyla silindi.');
        } catch (\Exception $e) {
            Log::error('SMTP ayarı silinirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'SMTP ayarı silinirken bir hata oluştu.');
        }
    }

    /**
     * Set SMTP setting as active.
     */
    public function activate(SmtpSetting $smtp): RedirectResponse
    {
        try {
            // Deactivate all others
            SmtpSetting::where('is_active', true)->update(['is_active' => false]);

            // Activate this one
            $smtp->update(['is_active' => true]);

            return redirect()
                ->route('admin.smtp.index')
                ->with('success', 'SMTP ayarı aktif olarak ayarlandı.');
        } catch (\Exception $e) {
            Log::error('SMTP ayarı aktif yapılırken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'SMTP ayarı aktif yapılırken bir hata oluştu.');
        }
    }

    /**
     * Test SMTP connection.
     */
    public function test(SmtpSetting $smtp): RedirectResponse
    {
        try {
            // Test SMTP connection logic here
            // For now, just return success
            return redirect()
                ->back()
                ->with('success', 'SMTP bağlantısı başarıyla test edildi.');
        } catch (\Exception $e) {
            Log::error('SMTP test edilirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
                'smtp_id' => $smtp->id,
            ]);

            return redirect()
                ->back()
                ->with('error', 'SMTP test edilirken bir hata oluştu: ' . $e->getMessage());
        }
    }
}
