<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\Login as BaseAuth;

class Login extends BaseAuth
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'remember' => true,
        ]);
    }
}
