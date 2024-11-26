<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;

new class extends Component {
    use WithPagination;

    public $headers = [
        ['key' => 'id', 'label' => 'Id'],
        ['key' => 'name', 'label' => 'Nama'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'role.name', 'label' => 'Role'],
    ];

    public function render(): mixed
    {
        return view('livewire.direktori-user', [
            'users' => User::with('role')->paginate(15),
        ]);
    }

    public function edit($id)
    {
        return;
    }

    public function remove($id)
    {
        return;
    }
}; ?>

<div>
    <x-card title="Data Users" class="flex mx-3 my-3 bg-base-200 rounded-xl" subtitle="Daftar semua Admin dan Petugas">
        <x-table :headers="$headers" :rows="$users" with-pagination>
        {{-- Special `actions` slot --}}
            @scope('cell_latest_progres', $users)
            <p>{{ $users->latest_progres ?? '0' }}%</p>
            @endscope
            @scope('actions', $user)
            <div class="flex gap-2">
                {{-- <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm"/> --}}
                <x-button icon="o-pencil-square" wire:click="edit({{ $user->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
