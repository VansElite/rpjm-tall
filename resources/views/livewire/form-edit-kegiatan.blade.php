<?php

use App\Models\Bidang; //Opsi x-select
use App\Models\Program; //Opsi x-select
use App\Models\Dusun; //Opsi x-select
use App\Models\Kegiatan;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Renderless;
use Livewire\Volt\Component;

new class extends Component {
    //init Data
    public Kegiatan $kegiatan;

    //init data untuk Alphinejs

    //init Opsi x-select
    public $bidangs;
    public $programs;
    public $dusuns;
    public $statuses;
    public $satuans;

    //init Opsi default x-select
    public $tempBidangs;
    public $tempPrograms;
    public $tempDusuns;

    //init input data
    public $namaBidang;
    public $selectedBidang;
    public $selectedProgram;
    public $nama;
    public $selectedStatus;
    public $volume;
    public $selectedSatuan;
    public $tahun_1;
    public $tahun_2;
    public $tahun_3;
    public $tahun_4;
    public $tahun_5;
    public $tahun_6;
    public $lokasi;
    public $selectedDusun;
    public $longitude;
    public $latitude;
    public $deskripsi;

    public function mount()
    {
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

        // Data untuk Opsi x-select
        $this->bidangs = [$this->tempBidangs,
            ...Bidang::all()->toArray()
        ];
        $this->programs = [$this->tempPrograms,
            ...Program::all()->toArray()
        ];
        $this->dusuns = [$this->tempDusuns,
            ...Dusun::all()->toArray()];
        $this->statuses = [
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
        $this->satuans = [
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
            [
                'id' => 5,
                'value' => 'ok',
                'nama' => 'OK',
            ],
            [
                'id' => 6,
                'value' => 'siswa',
                'nama' => 'Siswa',
            ],
            [
                'id' => 7,
                'value' => 'ls',
                'nama' => 'Lusin',
            ],
            [
                'id' => 8,
                'value' => 'orang',
                'nama' => 'Orang',
            ],
        ];
        // init prop component untuk map
        $this->namaBidang = $this->kegiatan->program->bidang->nama;

        // Isi nilai properti component dengan data kegiatan
        $this->selectedBidang = $this->kegiatan->program->id_bidang;
        $this->nama = $this->kegiatan->nama;
        $this->selectedProgram = $this->kegiatan->id_program;
        $this->selectedStatus = $this->kegiatan->status;
        $this->volume = $this->kegiatan->volume;
        $this->selectedSatuan = $this->kegiatan->satuan;
        $this->tahun_1 = $this->kegiatan->tahun_1;
        $this->tahun_2 = $this->kegiatan->tahun_2;
        $this->tahun_3 = $this->kegiatan->tahun_3;
        $this->tahun_4 = $this->kegiatan->tahun_4;
        $this->tahun_5 = $this->kegiatan->tahun_5;
        $this->tahun_6 = $this->kegiatan->tahun_6;
        $this->lokasi = $this->kegiatan->lokasi;
        $this->selectedDusun = $this->kegiatan->id_dusun;
        $this->longitude = $this->kegiatan->longitude;
        $this->latitude = $this->kegiatan->latitude;
        $this->deskripsi = $this->kegiatan->deskripsi;
    }

    //Update Selected Bidang
    public function updatedSelectedBidang($bidangId)
    {
        // Filter data berdasarkan bidang yang dipilih
        $this->programs = Program::where('id_bidang', $bidangId)->get();
    }

    //Update longitude Latitude
    public function setCoordinates($lng, $lat)
    {
        $this->longitude = value($lng);
        $this->latitude = value($lat);
    }

    public function cancle()
    {
        return redirect()->route('direktori-kegiatan');
    }

    public function save()
    {
        $this->kegiatan->update([
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

        session()->flash('message', 'Data Bidang berhasil diupdate.');
        // Kembali ke halaman daftar kegiatan atau halaman lain yang sesuai
        return redirect()->route('direktori-kegiatan');
    }
}; ?>

<div>
    <x-card title="Edit Kegiatan {{ $kegiatan->nama }}" class="flex mx-3 my-3 bg-base-200 rounded-xl" separator>
        <x-form wire:submit.prevent="save">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-select label="Bidang" :options="$bidangs" option-value="id" option-label="nama"
                        wire:model.live="selectedBidang" />
                </div>
                <div>
                    <x-select label="Program" :options="$programs" option-value="id" option-label="nama"
                        wire:model="selectedProgram" />
                </div>
            </div>

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
                    {{-- deklarasi true = 1 false = 1 --}}
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
                    {{-- Show data longitude dari Alphine Js --}}
                    <x-input label="Longitude" wire:model="longitude" />
                </div>
                <div>
                    {{-- Show data latitude dari Alphine Js --}}
                    <x-input label="Latitude" wire:model="latitude" />
                </div>
                <div wire:ignore class="col-span-2">
                    <div class="h-48 w-160" id='peta'></div>
                </div>
            </div>
            <hr />

            <x-textarea label="Deskripsi" wire:model="deskripsi" placeholder="Tuliskan Deskripsi Kegiatan ..."
                hint="Max 1000 chars" rows="5" inline />

            <x-slot:actions>
                <x-button label="Cancel" wire:click="cancle" />
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

        console.log($wire.get('namaBidang'));

        const createMarker = (coordinate, map, color, title) =>
            new mapboxgl.Marker({
                color: color,
                draggable: true
            })
            .setPopup(new mapboxgl.Popup().setText(title))
            .setLngLat(coordinate)
            .addTo(map)

        const warnaBidang = {
            'Pendidikan': '#40e0d0',
            'Kesehatan': '#b4c6d0',
            'Penataan Ruang': '#4a8bad',
            'Kawasan Pemukiman': '#ffff00',
            'Lingkungan Hidup': '#00ff00',
            'Perhubungan dan Infokom': '#e23a08',
            'Pariwisata': '#492971',
            'Default': '#42f545',
        }

        const kegiatanMarker = createMarker(
            [$wire.get('longitude'),$wire.get('latitude')],
            map,
            warnaBidang[$wire.get('namaBidang')],
            $wire.get('nama')
        )

        kegiatanMarker.on('dragend', (eventStatus) => {
            const marker = eventStatus.target
            const coordinate = marker.getLngLat()
            const longitude = coordinate.lng
            const latitude = coordinate.lat
            $wire.setCoordinates(longitude,latitude)
        })

    </script>
@endscript
