<?php

use App\Models\Kegiatan;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search;
    public bool $showDetail = false;
    public ?Kegiatan $selectedKegiatan = null; // Properti untuk menyimpan kegiatan yang dipilih


    public $headers = [
        ['key' => 'nama', 'label' => 'Nama Kegiatan', 'class' => 'text-center w-1/4'],
        ['key' => 'dusun_nama', 'label' => 'Dusun', 'class' => 'text-center w-1/6'],
        ['key' => 'laporan_progres', 'label' => 'Progres', 'class' => 'text-center w-1/6'],
    ];


    public function render(): mixed
    {
        // $this->kegiatans = Laporan::with(['kegiatan','kegiatan.dusun'])->get();

        return view('livewire.index', [
            'kegiatans' => Kegiatan::withAggregate('laporan','progres')
            ->withAggregate('dusun','nama')
            ->paginate(5), // Menggunakan paginate
        ]);
    }

    // Fungsi untuk memilih kegiatan dan menampilkan detailnya
    public function selectKegiatan($id)
    {
        $this->selectedKegiatan = Kegiatan::with(['dusun', 'laporan'])->find($id);
        $this->showDetail = !$this->showDetail;
    }

    public function getShowDetailProperty()
    {
        return !is_null($this->selectedKegiatan);
    }

}; ?>

<div class="grid h-full grid-cols-12 gap-4">
    <!-- Bagian Tabel (3 dari 12 kolom) -->
    <div class="col-span-3 grid-rows-5">
        <x-card class="row-span-1 text-xs" body-class="p-1">
            <x-input label="Cari Kegiatan" class="h-10" wire:model="search" icon-right="o-magnifying-glass" inline />
        </x-card>

        <x-card class="w-full row-span-3 text-xs" title="Daftar Kegiatan" style="padding: 0.25rem;">
            <div class="overflow-x-auto">
                <x-table :headers="$headers" :rows="$kegiatans" class="w-full p-1 text-xs">
                    @scope('cell_laporan_progres', $kegiatan)
                    <p>{{ $kegiatans->laporan_progres ?? '0' }}%</p>
                    @endscope
                    @scope('actions', $kegiatan)
                    <x-button icon="o-folder-open" wire:click="selectKegiatan({{ $kegiatan->id }})" spinner
                        class="w-1/6 btn-xs" />
                    @endscope
                </x-table>
            </div>
        </x-card>

        <!-- Filter Dropdowns -->
        <div class="flex row-span-1 gap-2 mt-4">
            <x-dropdown label="Filter 1" class="btn-outline">
                <x-menu-item title="Hey" />
                <x-menu-item title="How are you?" />
            </x-dropdown>
            <x-dropdown label="Filter 2">
                <x-menu-item title="Hey" />
                <x-menu-item title="How are you?" />
            </x-dropdown>
            <x-dropdown label="Filter 3">
                <x-menu-item title="Hey" />
                <x-menu-item title="How are you?" />
            </x-dropdown>
        </div>
    </div>
    <!-- Bagian Card (4 dari 12 kolom), ditampilkan berdasarkan showDetail -->
    @if ($showDetail)
    <div class="col-span-4 space-y-4">
        <!-- Detail Kegiatan -->
        <x-card title="Detail Kegiatan {{ $selectedKegiatan->nama }}" class="w-full h-80 bg-base-200" separator>
            <p>Status {{ $selectedKegiatan->status }}</p>
            <p>Lokasi {{ $selectedKegiatan->dusun->nama ?? '-' }}</p>
            <p>Tahun Pelaksanaan</p>
            <p>Progres: <x-progress-radial value="{{ $selectedKegiatan->laporan_progres ?? '0' }}" /></p>
            <menu-separator/>
            <p>{{ $selectedKegiatan->deskripsi }}</p>
        </x-card>

        <!-- Laporan Kegiatan -->
        <x-card title="Laporan Kegiatan {{$selectedKegiatan->nama}}" class="w-full h-80 bg-base-200" separator>
            <x-slot:actions>
                <x-button label="Tambah Laporan" class="btn-primary" />
            </x-slot:actions>
            <div class="grid grid-flow-row auto-rows-max">
                @foreach ($selectedKegiatan->laporan as $laporan)
                <x-timeline-item
                    title="{{ $laporan->judul }}"
                    subtitle="{{ $laporan->created_at->format('d M Y') }}"
                    description="{{ $laporan->deskripsi }}" />
                @endforeach
            </div>
        </x-card>
    </div>
    @endif

    <!-- Bagian Map (5 dari 12 kolom) -->
    <div class="{{ $showDetail ? 'col-span-5' : 'col-span-9' }}">
        <div wire:ignore class="w-full h-full" id="peta"></div>
    </div>
</div>

@script
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoidmFuc2VsaXRlMjEiLCJhIjoiY20yeWd2dDZyMDB3MjJtc2piZjE1ZDk0OSJ9.yDmaTMSvuPWK-iDhvldKWg';
const map = new mapboxgl.Map({
	container: 'peta', // container ID
	style: 'mapbox://styles/mapbox/streets-v12', // style URL
	center: [110.299322, -7.9701668], // starting position [lng, lat]
	zoom: 13, // starting zoom
});


</script>
@endscript
