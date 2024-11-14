<?php

use App\Models\Kegiatan;
use Livewire\Volt\Component;
use Livewire\WithPagination;


new class extends Component {
    use WithPagination;

    public $statuses = [
        [
            'id' => 1,
            'value' => 'selesai',
            'nama' => 'Selesai',
        ],
        [
            'id' => 2,
            'value' => 'sedangBerjalan',
            'nama' => 'Sedang Berjalan',
        ],
        [
            'id' => 3,
            'value' => 'direncanakan',
            'nama' => 'Direncanakan',
        ],
    ];

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'nama', 'label' => 'Nama Kegiatan'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'laporan_progres', 'label' => 'Progres'],
    ];

    public function render(): mixed
    {
        return view('livewire.direktori-kegiatan', [
            'kegiatans' => Kegiatan::withAggregate('laporan', 'progres')->paginate(10), // Menggunakan paginate
        ]);
    }

    public function edit($id)
    {
        return to_route('edit-kegiatan', $id);
    }

    public function delete($id)
    {
        Kegiatan::destroy($id);
        return to_route('direktori-kegiatan');
    }

}; ?>

<div>
    <x-card title="Data Kegiatan RPJM Tirtomulyo" class="flex mx-3 my-3 bg-base-200 rounded-xl" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo" separator>
        <x-table :headers="$headers" :rows="$kegiatans" with-pagination>
        {{-- Special `actions` slot --}}
            @scope('actions', $kegiatan)
            <div class="flex gap-2">
                <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm"/>
                <x-button icon="o-pencil-square" wire:click="edit({{ $kegiatan->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $kegiatan->id }})" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
