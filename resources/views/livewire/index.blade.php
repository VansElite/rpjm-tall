<?php

use App\Models\Kegiatan;
use Livewire\Volt\Component;
use Livewire\WithPagination;

$pseudoCodeLogic = "

params = readParams()

getRows(params)
getCoords(params)

on.paramChange {
    getRows(params)
    drawCoords(params)
}

on.showDetail (kegiatan) {
    drawCoords(kegiatan)
}

";

new class extends Component
{
    use WithPagination;

    public string $search;

    public bool $showDetail = false;

    public ?Kegiatan $selectedKegiatan = null; // Properti untuk menyimpan kegiatan yang dipilih

    public $detailKegiatan = [];

    public $headers = [
        ['key' => 'nama', 'label' => 'Nama Kegiatan', 'class' => 'text-center w-1/4'],
        ['key' => 'dusun_nama', 'label' => 'Dusun', 'class' => 'text-center w-1/6'],
        ['key' => 'latest_progres', 'label' => 'Progres', 'class' => 'text-center w-1/6'],
    ];

    // public $coordinates;

    public function mount()
    {
        // $this->coordinates = Kegiatan::select('id', 'latitude', 'longitude')->get();
        // dd($this->coordinates[0]['latitude']);
    }

    public function render(): mixed
    {
        // $this->kegiatans = Laporan::with(['kegiatan','kegiatan.dusun'])->get();

        $kegiatans = Kegiatan::withAggregate('dusun', 'nama')->withAggregate('laporan', 'progres')
            ->with('latestProgress')
            ->paginate(5);

        // Menambahkan progres terakhir ke dalam array headers untuk setiap kegiatan
        foreach ($kegiatans as $kegiatan) {
            $kegiatan->latest_progres = $kegiatan->latestProgress->progres ?? '0'; // Nilai default 0 jika tidak ada laporan
        }

        return view('livewire.index', [
            'kegiatans' => $kegiatans,
        ]);
    }

    // Fungsi untuk memilih kegiatan dan menampilkan detailnya
    public function selectKegiatan($id)
    {
        $this->selectedKegiatan = Kegiatan::with(['dusun', 'laporan'])->find($id);
        $this->setupDetailKegiatan();
        $this->showDetail = ! $this->showDetail;
    }

    public function getShowDetailProperty()
    {
        return ! is_null($this->selectedKegiatan);
    }

    public function setupDetailKegiatan()
    {
        $this->detailKegiatan = [
            [
                'name' => 'Status',
                'data' => $this->selectedKegiatan->status,
            ],
            [
                'name' => 'Progress',
                'data' => $this->selectedKegiatan->laporan->isNotEmpty()
                    ? $this->selectedKegiatan->laporan->last()->progres.'%'
                    : '0%',
            ],
            [
                'name' => 'Bidang',
                'data' => $this->selectedKegiatan->program->bidang->nama,
            ],
            [
                'name' => 'Program',
                'data' => $this->selectedKegiatan->program->nama,
            ],
            [
                'name' => 'Dusun',
                'data' => $this->selectedKegiatan->dusun->nama,
            ],
            [
                'name' => 'Volume',
                'data' => $this->selectedKegiatan->volume.' '.$this->selectedKegiatan->satuan,
            ],
            [
                'name' => 'Tahun',
                'data' => ($this->selectedKegiatan->tahun_1 ? '1, ' : '')
                    .($this->selectedKegiatan->tahun_2 ? '2, ' : '')
                    .($this->selectedKegiatan->tahun_3 ? '3, ' : '')
                    .($this->selectedKegiatan->tahun_4 ? '4, ' : '')
                    .($this->selectedKegiatan->tahun_5 ? '5, ' : '')
                    .($this->selectedKegiatan->tahun_6 ? '6' : ''),
            ],
            [
                'name' => 'Lokasi',
                'data' => $this->selectedKegiatan->lokasi,
            ],
            [
                'name' => 'Koordinat',
                'data' => $this->selectedKegiatan->latitude.', '.$this->selectedKegiatan->longitude,
            ],
            [
                'name' => 'Deskripsi',
                'data' => $this->selectedKegiatan->deskripsi,
            ],
        ];
    }
}; ?>

<div class="grid h-full grid-cols-3">
    <!-- Bagian Tabel (3 dari 12 kolom) -->
    <div>
        <x-card class="w-full text-xs" title="Daftar Kegiatan" style="padding: 0.25rem;">
            <div class="">
                <x-table :headers="$headers" :rows="$kegiatans" class="w-full p-1 text-xs">
                    @scope('cell_latest_progres', $kegiatans)
                    <p>{{ $kegiatans->latest_progres ?? '0' }}%</p>
                    @endscope
                    @scope('actions', $kegiatan)
                    <x-button icon="o-folder-open" wire:click="selectKegiatan({{ $kegiatan->id }})" spinner
                        class="w-1/6 btn-xs" />
                    @endscope
                </x-table>
                {{ $kegiatans->onEachSide(0)->links() }}
                {{ $kegiatans->firstItem() }}
                {{ $kegiatans->lastItem() }}
                {{ $kegiatans->total() }}
                {{ $kegiatans->currentPage() }}
                <a wire:click="gotoPage(7, 'page')">hell</a>
            </div>
        </x-card>

        <!-- Filter Dropdowns -->
        <div class="flex gap-2 mt-4">
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
    <div class="p-4 bg-base-200 overflow-auto">
        <!-- Detail Kegiatan -->
        <div class="mb-4 flex items-center">
            <h2 class="text-md font-bold">Detail Kegiatan {{ $selectedKegiatan->nama }}</h2>
            <x-button
                icon="m-pencil-square"
                link="{{ route('edit-kegiatan', ['kegiatan' => $selectedKegiatan->id]) }}"
                spinner
                class="ml-2 btn-sm btn-ghost"
            />
        </div>

        <div class="flex flex-col">
            <table class="table">
                <tbody>
                    @foreach($detailKegiatan as $d)
                    <tr>
                        <td class="opacity-60 p-0">{{ $d['name'] }}</td>
                        <td class="p-0">: {{ $d['data'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laporan Kegiatan -->
        <div class="flex my-4">
            <h2 class="text-md font-bold">Laporan Kegiatan</h2>
            <x-button
                icon="o-plus"
                link="{{
                    route('add-laporan', [
                        'selectedBidang' => $selectedKegiatan->program->bidang->id,
                        'selectedProgram' => $selectedKegiatan->program->id,
                        'selectedKegiatan' => $selectedKegiatan->id,
                    ])
                }}"
                class="col-span-1 ml-2 justify-content-center h-fit btn-square btn-xs btn-outline"
            />
        </div>
        <ul class="timeline timeline-vertical">
            @foreach ($selectedKegiatan->laporan as $laporan)
                <li>
                    <hr />
                    <div class="timeline-start text-right">
                        {{ $laporan->progres }}%
                        <p class="opacity-80">{{ $laporan->created_at->format('d-M-Y H:i') }}</p>
                    </div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end">
                        <div class="flex items-center">
                            <span class="font-bold">{{ $laporan->judul}}</span>
                            <x-button
                                icon="m-pencil-square"
                                link="{{ route('edit-laporan', ['laporan' => $laporan->id]) }}"
                                spinner
                                class="ml-2 btn-sm btn-ghost"
                            />
                        </div>
                        <p class="opacity-80">{{ $laporan->deskripsi}}</p>
                    </div>
                    <hr />
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Bagian Map (5 dari 12 kolom) -->
    <div class="{{ $showDetail ? 'col-span-1' : 'col-span-2' }}">
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
