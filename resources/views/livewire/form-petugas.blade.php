<?php

use App\Models\Role;
use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {

    public $name;
    public $email;
    public $roleId;
    public $password;
    public $passwordConfirm;

    public function render(): mixed
    {
        return view('livewire.form-petugas', [
            'roles' => Role::all(),
        ]);
    }

    public function mount()
    {
        $this->roleId = 1;
    }

    public function store()
    {
        if ($this->password !== $this->passwordConfirm) {
            return;
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => 1,
            'password' => $this->password,
        ]);

        session()->flash('message', 'Data petugas berhasil disimpan.');

        return redirect()->route('direktori-petugas');
    }
}; ?>

<div>
    <x-card title="Form Tambah Petugas" class="flex mx-3 my-3 bg-base-200 rounded-xl">
        <x-form wire:submit.prevent="store" class="m-4">
            <x-input label="Nama" wire:model="name" />
            <x-input label="Email" wire:model="email" />
            <x-password label="Password" wire:model="password" />
            <x-password label="Confirm Password" wire:model="passwordConfirm" />
            <x-slot:actions>
                <x-button label="Simpan" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
