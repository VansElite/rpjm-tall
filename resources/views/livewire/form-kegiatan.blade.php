<?php

use App\Models\Bidang;
use App\Models\Program;
use Livewire\Volt\Component;

new class extends Component {
    public $users = [
        [
            'id' => 1,
            'name' => 'Joe',
        ],
        [
            'id' => 2,
            'name' => 'Mary',
            'disabled' => true,
        ],
    ];
    public $bidangs;
    public $selectedBidang;

    public $programs;

    public function mount()
    {
        $this->bidangs = Bidang::all();
        //where('id_bidang')
        $this->programs = Program::all();
    }


}; ?>

<div>
    <x-form wire:submit.prevent="handleSubmit">
        <x-select label="Bidang" icon="o-user" :options="$bidangs" option-value="id" option-label="nama" wire:model.live="selectedBidang" />
        <x-select label="Program" icon="o-user" :options="$programs" option-value="id" option-label="nama" wire:model="selectedUser" />
        <x-input label="Nama Kegiatan" wire:model="name" />
        <x-select label="Status" icon="o-user" :options="$users" wire:model="selectedUser" />
        <x-input label="Volume" wire:model="name" />
        <x-select label="Satuan" icon="o-user" :options="$users" wire:model="selectedUser" />
        <x-input label="Lokasi" wire:model="name" />
        <x-select label="Dusun" icon="o-user" :options="$users" wire:model="selectedUser" />
        <x-input label="Longitude" wire:model="name" />
        <x-input label="Latitude" wire:model="name" />
        <x-menu-separator />
        <x-textarea label="Deskripsi" wire:model="bio" placeholder="Your story ..." hint="Max 1000 chars" rows="5"
            inline />

        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>

@script
    <script>
        function handleSubmit() {
            // Lakukan sesuatu di sini, misalnya menampilkan alert
            alert('Form submitted!');
        }
    </script>
@endscript
