<?php

use function Livewire\Volt\{state,mount};
use App\Models\Bidang;

state([
    'headers' => [],
    'data' => [],
]);

mount(function () {
    $this->headers = [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'nama', 'label' => 'Nama Bidang'],
    ];
    $this->data = Bidang::all();
});

$delete = function ($id) {
    Bidang::destroy($id);
    return to_route('direktori-bidang');
}

?>

<div class="m-4">
    <x-table :headers="$headers" :rows="$data">
        @scope('actions', $row_bidang)
            <x-button icon="o-trash" wire:click="delete({{ $row_bidang->id }})" spinner class="btn-sm" />
        @endscope
    </x-table>
</div>
