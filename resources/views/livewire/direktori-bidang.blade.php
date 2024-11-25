<?php

use App\Models\Bidang;
use Livewire\Volt\Component;

new class extends Component {
    public $bidangs;

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'nama', 'label' => 'Nama Bidang'],
    ];

    public function mount()
    {
        $this->bidangs = Bidang::all();
    }

    public function edit($id)
    {
        return to_route('edit-bidang', $id);
    }

    public function delete($id)
    {
        Bidang::destroy($id);
        return to_route('direktori-bidang');
    }
}; ?>

<div>
    <x-card title="Data Bidang RPJM Tirtomulyo" class="flex mx-3 my-3 bg-base-200 rounded-xl" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo" separator>
        <x-table :headers="$headers" :rows="$bidangs">
            {{-- Special `actions` slot --}}
            @scope('actions', $bidang)
            <div class="flex gap-2">
                {{-- <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm" /> --}}
                <x-button icon="o-pencil-square" wire:click="edit({{ $bidang->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $bidang->id }})" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
