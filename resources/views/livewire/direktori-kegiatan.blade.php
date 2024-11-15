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
        ['key' => 'latest_progres', 'label' => 'Progres'],
    ];

    public function render(): mixed
    {
        $kegiatans = Kegiatan::withAggregate('laporan', 'progres')
            ->with('latestProgress')
            ->paginate(10);

        // Menambahkan progres terakhir ke dalam array headers untuk setiap kegiatan
        foreach ($kegiatans as $kegiatan) {
            $kegiatan->latest_progres = $kegiatan->latestProgress->progres ?? '0'; // Nilai default 0 jika tidak ada laporan
        }

        return view('livewire.direktori-kegiatan', [
            'kegiatans' => $kegiatans,
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
            @scope('cell_latest_progres', $kegiatans)
            <p>{{ $kegiatans->latest_progres ?? '0' }}%</p>
            @endscope
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
