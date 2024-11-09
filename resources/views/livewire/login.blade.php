<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Layout('components.layouts.empty')]       // <-- Here is the `empty` layout
#[Title('Login')]
class extends Component {

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public function mount()
    {
        // It is logged in
        if (auth()->user()) {
            return redirect('/');
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();

            return redirect()->intended('/');
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }
}

?>

    <div class="mx-auto mt-20 md:w-96">
        <x-card>
            <div class="mb-5 text-2xl font-bold text-center">RPJM Tirtomulyo</div>
            <div class="grid justify-items-center">
                <img src="{{ asset('images/hd-logo.png') }}" class="mb-5 max-h-32 max-w-25"/>
            </div>

            <x-form wire:submit="login">
                <x-input label="E-mail" wire:model="email" icon="o-envelope" inline />
                <x-input label="Password" wire:model="password" type="password" icon="o-key" inline />

                <x-slot:actions>
                    <x-button label="Home" href="/" wire:navigate />
                    <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login"/>
                </x-slot:actions>
            </x-form>
        </x-card>
    </div>



