<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use App\Models\Kegiatan;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
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

    public $satuans = [
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

    public $users = [
        [
            'id' => 1,
            'name' => 'Joe',
        ],
        [
            'id' => 2,
            'name' => 'Mary',
            'disabled' => true,
        ],
    ];

    //init data dari db
    public $bidangs;
    public $programs;
    public $dusuns;

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
    public $progres = 0;
    #[Validate('required', message: 'Jangan Kosongkan Deksripsi Kegiatan')]
    public $deskripsi;


    //Inisialisasi $ yang diperlukan dalam logic
    public function mount()
    {
        $this->selectedBidang = null;

        $this->bidangs = Bidang::all();

        //where('id_bidang')
        $this->programs = Program::all();

        $this->dusuns = Dusun::all();
    }
    //Update Selected Bidang
    public function updatedSelectedBidang($bidangId)
    {
        // Filter data berdasarkan bidang yang dipilih
        $this->programs = Program::where('id_bidang', $bidangId)->get();
    }

    public function store()
    {

        $validated = $this->validate();

        Kegiatan::create([
            'nama' => $this->nama,
            'id_program' => $this->selectedProgram,
            'status' => $this->selectedStatus,
            'volume' => $this->nama,
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
            'progres' => $this->progres,
            'deskripsi' => $this->deskripsi,
    ]);

    session()->flash('message', 'Data berhasil disimpan.');
    }
}; ?>

<div>
    <x-form wire:submit.prevent="store">
        <x-select label="Bidang" :options="$bidangs" option-value="id" option-label="nama" wire:model.live="selectedBidang" />
        <div class="grid grid-cols-10 gap-4 h-30">
            <div class="col-span-8">
                <x-select label="Program" :options="$programs" option-value="id" option-label="nama"
                    wire:model="selectedProgram" />
            </div>
            <div class="justify-center col-span-2 mx-5 pt-7 ">
                <x-button label="Tambah Program" icon="o-home" class="btn-outline" responsive />
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
                <x-input label="Longitude" wire:model="longitude" />
            </div>
            <div>
                <x-input label="Latitude" wire:model="latitude" />
            </div>
            <div class="col-span-2">
                <x-textarea label="Mapbox" />
            </div>
        </div>
        <hr />

        <x-textarea label="Deskripsi" wire:model="deskripsi" placeholder="Tuliskan Deskripsi Kegiatan ..." hint="Max 1000 chars" rows="5"
            inline />

        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>

@script
<script>
    function handleSubmit() {
            // Lakukan sesuatu di sini, misalnya menampilkan alert
            alert('Form submitted!');
        }
</script>
@endscript
