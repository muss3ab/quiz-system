<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MemberDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.member-dashboard';
    protected static ?string $title = 'Dashboard';

    public function mount()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->to('/admin');
        }
    }

    protected function getViewData(): array
    {
        return [
            'available_quizzes' => Quiz::where('is_active', true)
                ->whereDoesntHave('attempts', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->get(),
            'completed_quizzes' => Quiz::whereHas('attempts', function ($query) {
                $query->where('user_id', Auth::id());
            })->get(),
        ];
    }

}
