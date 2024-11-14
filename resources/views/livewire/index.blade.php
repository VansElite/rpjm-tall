<?php

use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\Laporan;
use Livewire\Volt\Component;

new class extends Component {
    public Kegiatan $kegiatan;
    Public Laporan $laporan;
    public $kegiatans;

    public string $search;

    public $headers = [
        ['key' => 'kegiatan.id', 'label' => 'No'],
        ['key' => 'kegiatan.nama', 'label' => 'Nama Kegiatan'],
        ['key' => 'kegiatan.dusun.nama', 'label' => 'Dusun'],
        ['key' => 'progres', 'label' => 'Progres'],
    ];

    public function mount()
    {
        $this->search = '';

    }

    public function mounted()
    {

    }

    public function boot()
    {
        $this->kegiatans = Laporan::with(['kegiatan','kegiatan.dusun'])->get(); //Sementara pake laporan dulu

    }

    public function updatedSearch($namaKegiatan)
    {
        $this->kegiatans= Laporan::with(['kegiatan'=>function ($querry) {$querry->where('nama',$namaKegiatan);},'kegiatan.dusun'])->get();
    }


}; ?>

<div class="grid h-full grid-cols-12">
    <div class="grid h-full col-span-3 grid-rows-5">

        <div class="flex-auto row-span-1 gap-1 md:grid-row-2">
            <input type="text" placeholder="ketik nama kegiatan" wire:model='search' class="w-4/5 row-span-1 mx-5">
            <x-tabs wire:model="selectedTab" class="flex justify-center flex-auto row-span-1">
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
                @scope('actions', $kegiatan)
                <div class="flex gap-2">
                    <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm" />
                </div>
                @endscope
            </x-table>
        </div>

        <div class="grid grid-cols-3 row-span-1 gap-1">
            <div class="flex-auto col-span-1">
                <x-dropdown label="Filter 1" class="btn-outline" no-x-anchor>
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
    {{-- @if ($showProgram) --}}
    <div class="grid h-full col-span-4 md:grid-row-7">
        <x-card title="Detail kegiatan X" class="row-span-4 mx-2 my-2 h-fit bg-base-200" separator>

        </x-card>
        <x-card title="Laporan kegiatan X" class="row-span-3 mx-2 my-2 h-fit w-8/9 bg-base-200" separator>
            <div>
                List-item
            </div>
            <x-slot:actions>
                <x-button label="Ok" class="btn-primary" />
            </x-slot:actions>
        </x-card>
    </div>

    <div class="w-full h-full col-span-5" id='peta'></div>
    {{-- @endif --}}
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
