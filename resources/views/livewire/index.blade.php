<?php

use App\Models\Kegiatan;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search;

    public $headers = [
        ['key' => 'id', 'label' => 'No','class' => 'w-1'],
        ['key' => 'nama', 'label' => 'Nama Kegiatan', 'class' => 'max-w-20'],
        ['key' => 'dusun_nama', 'label' => 'Dusun', 'class' => 'max-w-10'],
        ['key' => 'laporan_progres', 'label' => 'Progres', 'class' => 'max-w-10'],
    ];


    public function render(): mixed
    {
        // $this->kegiatans = Laporan::with(['kegiatan','kegiatan.dusun'])->get();

        return view('livewire.index', [
            'kegiatans' => Kegiatan::withAggregate('laporan','progres')->withAggregate('dusun','nama')->paginate(5), // Menggunakan paginate
        ]);
    }


    // public function updatedSearch($namaKegiatan)
    // {
    //     $this->kegiatans= Laporan::with(['kegiatan'=>function ($querry) {$querry->where('nama',$namaKegiatan);},'kegiatan.dusun'])->get();
    // }


}; ?>

<div class="grid h-full grid-cols-12 gap-4">
    <!-- Bagian Tabel (3 dari 12 kolom) -->
    <div class="col-span-3 grid-rows-5">
        <x-card class="row-span-1 text-sm">
            searchbar
        </x-card>

        <x-card class="row-span-3 text-sm" title="Daftar Kegiatan">
            <x-table :headers="$headers" :rows="$kegiatans" link="route('#')" class="w-full">
                @scope('cell_progres', $kegiatan)
                <x-badge class="badge-primary" />
                @endscope
            </x-table>

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

    <!-- Bagian Card (4 dari 12 kolom) -->
    <div class="col-span-4 space-y-4">
        <x-card title="Detail kegiatan X" class="w-full h-80 bg-base-200" separator>
            <!-- Content for detail can go here -->
        </x-card>

        <x-card title="Laporan kegiatan X" class="w-full h-80 bg-base-200" separator>
            <div>
                List-item
            </div>
            <x-slot:actions>
                <x-button label="Ok" class="btn-primary" />
            </x-slot:actions>
        </x-card>
    </div>

    <!-- Bagian Map (5 dari 12 kolom) -->
    <div class="w-full h-full col-span-5" id="peta"></div>
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
