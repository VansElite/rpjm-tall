<?php

use function Livewire\Volt\{state,mount};
use App\Models\Bidang;

state([
    'headers' => [],
    'data' => [],
]);

mount(function () {
    $this->headers = [
        ['key' => 'id', 'label' => 'Nomor'],
        ['key' => 'nama', 'label' => 'Nama Bidang'],
    ];
    $this->data = Bidang::all();
})

?>

<div class="m-4">
    <x-table :headers="$headers" :rows="$data" striped />
</div>
