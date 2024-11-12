<?php

use App\Models\Bidang;
use Livewire\Volt\Component;

new class extends Component {

    public $nama;

    public function store()
    {

        Bidang::create([
            'nama' => $this->nama,
        ]);

        session()->flash('message', 'Data Bidang berhasil disimpan.');

        return redirect()->route('direktori-bidang');
    }

}; ?>

<div>
    <x-card title="Form Tambah Bidang" class="flex mx-3 my-3 bg-base-200 rounded-xl">
        <x-form wire:submit.prevent="store" class="m-4">
            <x-input label="Nama Bidang" wire:model="nama" />
            <x-slot:actions>
                <x-button label="Simpan" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
