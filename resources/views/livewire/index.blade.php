<?php

use App\Models\Bidang;
use Livewire\Volt\Component;

new class extends Component {

    public $kegiatans;

    public string $search;

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'nama', 'label' => 'Nama Kegiatan'],
         // Masih ada kekurangan, dusun ambil dari Dusun
         // Masih ada kekurangan, progres ambil dari laporan
    ];

    public function mount()
    {
        $this->search = '';

        $this->kegiatans = Bidang::all();
    }

    public function updatedSearch($namaKegiatan)
    {
        $this->kegiatans= Bidang::where('nama',$namaKegiatan)->get();
    }


}; ?>

<div class="grid h-full grid-cols-12">
    <div class="grid col-span-3 grid-rows-5">

        <div class="flex-auto row-span-1 gap-1 grid-row-2">
            <input type="text" wire:model.live="search" class="flex-auto w-auto col-row-1">
            <x-tabs wire:model="selectedTab" class="flex justify-center flex-auto col-row-1">
                <x-tab name="users-tab" label="Users" icon="o-users">
                    <div>Users</div>
                </x-tab>
                <x-tab name="tricks-tab" label="Tricks" icon="o-sparkles">
                    <div>Tricks</div>
                </x-tab>
                <x-tab name="musics-tab" label="Musics" icon="o-musical-note">
                    <div>Musics</div>
                </x-tab>
            </x-tabs>
        </div>

        <div class="row-span-3">
            <x-table :headers="$headers" :rows="$kegiatans">

            </x-table>
        </div>

        <div class="grid grid-cols-3 row-span-1 gap-1">
            <div class="flex-auto col-span-1">
                <x-dropdown label="Filter 1" no-x-anchor>
                    <x-menu-item title="Hey" />
                    <x-menu-item title="How are you?" />
                </x-dropdown>
            </div>
            <div class="flex-auto col-span-1">
                <x-dropdown label="Filter 2" no-x-anchor>
                    <x-menu-item title="Hey" />
                    <x-menu-item title="How are you?" />
                </x-dropdown>
            </div>
            <div class="flex-auto col-span-1">
                <x-dropdown label="Filter 3" no-x-anchor>
                    <x-menu-item title="Hey" />
                    <x-menu-item title="How are you?" />
                </x-dropdown>
            </div>

        </div>

    </div>

    <div class="w-full h-full col-span-9" id='peta'></div>
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
