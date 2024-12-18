<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use App\Models\Kegiatan;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Renderless;
use Livewire\Volt\Component;

new class extends Component {
    public $statuses = [
        [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Status --',
        ],
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

    public $satuans = [
        [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Satuan --',
        ],
        [
            'id' => 1,
            'value' => 'meter',
            'nama' => 'Meter',
        ],
        [
            'id' => 2,
            'value' => 'kali',
            'nama' => 'Kali',
        ],
        [
            'id' => 3,
            'value' => 'paket',
            'nama' => 'Paket',
        ],
        [
            'id' => 4,
            'value' => 'unit',
            'nama' => 'Unit',
        ],
    ];

    //init data dari db
    public $bidangs;
    public $programs;
    public $dusuns;

    //init Opsi default x-select
    public $tempBidangs;
    public $tempPrograms;
    public $tempDusuns;

    //init var untuk fungsi
    public $showProgram = false;

    //init variable untuk addProgram
    #[Validate('required', message: 'Jangan Kosongkan Kolom Nama')]
    public $nama_program;
    #[Validate('required', message: 'Jangan Kosongkan Kolom Nama')]
    public $cangkupan_program;

    //init input data
    #[Validate('required', message: 'Tolong Pilih Salah Satu Bidang')]
    public $selectedBidang;
    #[Validate('required', message: 'Tolong Pilih Salah Satu Program')]
    public $selectedProgram;
    #[Validate('required', message: 'Jangan Kosongkan Nama')]
    public $nama;
    #[Validate('required', message: 'Tolong Pilih Salah Satu Status')]
    public $selectedStatus;
    #[Validate('required', message: 'Jangan Kosongan Volume')]
    public $volume;
    #[Validate('required', message: 'Tolong Pilih Salah Satu Status Kegiatan')]
    public $selectedSatuan;

    public $tahun_1 = false;
    public $tahun_2 = false;
    public $tahun_3 = false;
    public $tahun_4 = false;
    public $tahun_5 = false;
    public $tahun_6 = false;

    #[Validate('required', message: 'Jangan Kosongkan Lokasi Kegiatan')]
    public $lokasi;
    #[Validate('required', message: 'Tolong Pilih Salah Satu Dusun Kegiatan')]
    public $selectedDusun;
    #[Validate('required', message: 'Tolong Pilih Lokasi pada Map')]
    public $longitude;
    #[Validate('required', message: 'Tolong Pilih Lokasi pada Map')]
    public $latitude;
    #[Validate('required', message: 'Jangan Kosongkan Deksripsi Kegiatan')]
    public $deskripsi;

    //Inisialisasi $ yang diperlukan dalam logic
    public function mount()
    {

        $this->selectedBidang = null;

        //menambah data ke array pertama pada opsi x-select
        $this->tempBidangs =  [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Bidang --',
        ];
        $this->tempPrograms = [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Program --',
        ];
        $this->tempDusuns = [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Dusun --',
        ];

        $this->bidangs = [$this->tempBidangs,
            ...Bidang::all()->toArray()
        ];
        $this->programs = [$this->tempPrograms,
            ...Program::all()->toArray()
        ];
        $this->dusuns = [$this->tempDusuns,
            ...Dusun::all()->toArray()
        ];

    }
    //Update Selected Bidang
    public function updatedSelectedBidang($bidangId)
    {
        // Filter data berdasarkan bidang yang dipilih
        $this->programs = [$this->tempPrograms,
            ...Program::where('id_bidang', $bidangId)->get()->toArray()
        ];
    }

    public function showAddProgram()
    {
        $this->showProgram = !$this->showProgram;
    }

    public function createProgram()
    {
        Program::create([
            'nama' => $this->nama_program,
            'id_bidang' => $this->selectedBidang,
            'cangkupan_program' => $this->cangkupan_program,
        ]);
        $this->showProgram = !$this->showProgram;
    }

    //Update longitude Latitude
    public function setCoordinates($lng, $lat)
    {
        $this->longitude = value($lng);
        $this->latitude = value($lat);
    }

    public function save()
    {
        $this->validate();

        Kegiatan::create([
            'nama' => $this->nama,
            'id_program' => $this->selectedProgram,
            'status' => $this->selectedStatus,
            'volume' => $this->volume,
            'satuan' => $this->selectedSatuan,
            'tahun_1' => $this->tahun_1,
            'tahun_2' => $this->tahun_2,
            'tahun_3' => $this->tahun_3,
            'tahun_4' => $this->tahun_4,
            'tahun_5' => $this->tahun_5,
            'tahun_6' => $this->tahun_6,
            'lokasi' => $this->lokasi,
            'id_dusun' => $this->selectedDusun,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Data berhasil disimpan.');

        return redirect()->route('direktori-kegiatan');
    }
}; ?>

<div>
    <x-card title="Form Tambah Kegiatan" class="flex mx-3 my-3 bg-base-200 rounded-xl">
        <x-form wire:submit.prevent="save">
            <x-select label="Bidang" :options="$bidangs" option-value="id" option-label="nama" wire:model.live="selectedBidang" />
            <div class="grid grid-cols-10 gap-4 h-30">
                <div class="col-span-8">
                    <x-select label="Program" :options="$programs" option-value="id" option-label="nama"
                        wire:model="selectedProgram" />
                </div>
                <div class="justify-center col-span-2 mx-5 pt-7 ">
                    <x-button label="Program" icon="o-folder-plus" class="btn-outline" wire:click="showAddProgram"
                        responsive />
                </div>
            </div>
            {{-- Form Add Program --}}
            <hr />
            @if ($showProgram)
                <div class="grid gap-4 md:grid-cols-10">
                    <div class="col-span-5">
                        <x-input label="Nama Program" wire:model="nama_program" />
                    </div>
                    <div class="col-span-5">
                        <x-select label="Pilih Bidang" :options="$bidangs" option-value="id" option-label="nama"
                            wire:model.live="selectedBidang" />
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-10">
                    <div class="col-span-8">
                        <x-input label="Cangkupan Program" wire:model="cangkupan_program" />
                    </div>
                    <div class="justify-center col-span-2 mx-5 pt-7 ">
                        <x-button label="Simpan Program" icon="o-plus" class="btn-outline" wire:click="createProgram"
                            responsive />
                    </div>
                </div>
                <hr />
            @endif
            {{-- End Form Add Program --}}
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input label="Nama Kegiatan" wire:model="nama" />
                </div>
                <div>
                    <x-select label="Status" :options="$statuses" option-value="value" option-label="nama"
                        wire:model="selectedStatus" />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input label="Volume" wire:model="volume" />
                </div>
                <div>
                    <x-select label="Satuan" :options="$satuans" option-value="value" option-label="nama"
                        wire:model="selectedSatuan" />
                </div>
            </div>

            <div class="grid gap-16 my-2 md:grid-cols-6">
                <div>
                    <x-checkbox label="Tahun 1" wire:model="tahun_1" />
                </div>
                <div>
                    <x-checkbox label="Tahun 2" wire:model="tahun_2" />
                </div>
                <div>
                    <x-checkbox label="Tahun 3" wire:model="tahun_3" />
                </div>
                <div>
                    <x-checkbox label="Tahun 4" wire:model="tahun_4" />
                </div>
                <div>
                    <x-checkbox label="Tahun 5" wire:model="tahun_5" />
                </div>
                <div>
                    <x-checkbox label="Tahun 6" wire:model="tahun_6" />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input label="Lokasi" wire:model="lokasi" />
                </div>
                <div>
                    <x-select label="Dusun" :options="$dusuns" option-value="id" option-label="nama"
                        wire:model="selectedDusun" />
                </div>
            </div>

            <x-menu-separator />
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input label="Longitude" wire:model.live="longitude" readonly/>
                </div>
                <div>
                    <x-input label="Latitude" wire:model.live="latitude" readonly/>
                </div>
                <div wire:ignore class="w-full h-48 col-span-2">
                    <div class="h-48 w-160" id='peta'></div>
                </div>
            </div>
            <hr />

            <x-textarea label="Deskripsi" wire:model="deskripsi" placeholder="Tuliskan Deskripsi Kegiatan ..."
                hint="Max 1000 chars" rows="5" inline />

            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>

@script
    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoidmFuc2VsaXRlMjEiLCJhIjoiY20yeWd2dDZyMDB3MjJtc2piZjE1ZDk0OSJ9.yDmaTMSvuPWK-iDhvldKWg';

        const map = new mapboxgl.Map({
            container: 'peta', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
            center: [110.299322, -7.9701668], // starting position [lng, lat]
            zoom: 13, // starting zoom
        });

        const newCoordinateMarker = new mapboxgl.Marker({
                draggable: true
            })
            .setLngLat([110.26865751499571, -7.999424199143647])
            .addTo(map);
        // on-click di halaman
        map.on('click', e => {
            console.log(`[${e.lngLat.lng}, ${e.lngLat.lat}]`);
            newCoordinateMarker.setLngLat(e.lngLat);
            $wire.setCoordinates(e.lngLat.lng, e.lngLat.lat);
        });
    </script>
@endscript
