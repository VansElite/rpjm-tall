<?php
use App\Models\Kegiatan;
use App\Models\Laporan;
use Livewire\Volt\Component;

new class extends Component {
    public $kegiatans;

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
        [
            'id' => 4,
            'value' => 'ditunda',
            'nama' => 'Ditunda',
        ],
    ];

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'nama', 'label' => 'Nama Kegiatan'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'progres', 'label' => 'Progres'], // Masih ada kekurangan, progres ambil dari laporan
    ];

    public function mount()
    {
        $this->kegiatans = Kegiatan::all();
    }

    public function delete($id)
    {
        Kegiatan::destroy($id);
        return to_route('direktori-kegiatan');
    }

}; ?>

<div>
    <x-card title="Data Kegiatan RPJM Tirtomulyo" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo" separator>
        <x-table :headers="$headers" :rows="$kegiatans">
            {{-- Special `actions` slot --}}
                @scope('actions', $kegiatan)
                <div class="flex gap-2">
                    <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm" />
                    <x-button icon="o-pencil-square" wire:click="#" spinner class="btn-sm" />
                    <x-button icon="o-trash" wire:click="delete({{ $kegiatan->id }})" spinner class="btn-sm" />
                </div>
                @endscope
            </x-table>
    </x-card>
</div>
