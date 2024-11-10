<?php

use function Livewire\Volt\{state};
use App\Models\Bidang;

state([
    'nama' => '',
]);

$save = function () {
    Bidang::create(['nama' => $this->nama]);
    return to_route('direktori-bidang');
}

?>

<x-form wire:submit="save" class="m-4">
    <x-input label="Nama Bidang" wire:model="nama" />
    <x-slot:actions>
        <x-button label="Simpan" type="submit" class="btn-primary" />
    </x-slot:actions>
</x-form>
