<?php

use App\Models\Kegiatan;
use App\Models\Bidang;
use App\Models\Dusun;
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

new class extends Component {
    use WithPagination;

    public bool $showDetail = false;

    public array $activeFilters = []; //properti untuk menyimpan filter yang aktif
    public ?Kegiatan $selectedKegiatan = null; // Properti untuk menyimpan kegiatan yang dipilih
    public $selectedBidang; //prop filter bidang
    public $selectedDusun; //prop filter dusun
    public $selectedStatus; //prop filter Status
    public $selectedYear; //prop filter Tahun
    public string $search = ''; //prop untuk menyimpan input yang akan di search

    public $selectedDetail = []; //prop menyimpan data kegiatan yang dipilih untuk digunakan pada card detail dan laporan

    public $detailKegiatan = []; //prop menyimpan data kegiatan yang dipilih untuk digunakan pada card detail dan laporan

    public $dataMap = []; //prop menyimpan data kegiatan untuk digunakan ke js (mapbox)

    public $headers = [['key' => 'nama', 'label' => 'Nama Kegiatan', 'class' => 'text-center w-1/4'], ['key' => 'dusun_nama', 'label' => 'Dusun', 'class' => 'text-center w-1/6'], ['key' => 'latest_progres', 'label' => 'Progres', 'class' => 'text-center w-1/6']];

    protected $listeners = ['filter-updated' => 'applyFilter', 'removeFilter' => 'removeFilter'];

    public function applyFilter($filters)
    {
        $this->selectedBidang = $filters['selectedBidang'] ?? null;
        $this->selectedDusun = $filters['selectedDusun'] ?? null;
        $this->selectedStatus = $filters['selectedStatus'] ?? null;
        $this->selectedYear = $filters['selectedYear'] ?? null;

        // Perbarui activeFilters
        $this->activeFilters = [];

        if ($this->selectedBidang) {
            $bidangName = Bidang::find($this->selectedBidang)->nama ?? 'Unknown';
            $this->activeFilters[] = "Bidang: {$bidangName}";
        }

        if ($this->selectedDusun) {
            $dusunName = Dusun::find($this->selectedDusun)->nama ?? 'Unknown';
            $this->activeFilters[] = "Dusun: {$dusunName}";
        }

        if ($this->selectedStatus) {
            $status = $this->selectedStatus ?? 'Unknown';
            $this->activeFilters[] = "Status: {$status}";
        }

        if ($this->selectedYear) {
            $year = $this->selectedYear ?? 'Unknown';
            $this->activeFilters[] = "Tahun: {$year}";
        }

        $this->resetPage();
    }

    public function removeFilter($filterString)
    {
        [$type, $value] = explode(': ', $filterString);

        if ($type === 'Bidang') {
            $this->selectedBidang = null;
        } elseif ($type === 'Dusun') {
            $this->selectedDusun = null;
        } elseif($type === 'Status') {
            $this->selectedStatus = null;
        } elseif($type === 'Tahun') {
            $this->selectedYear = null;
        }

        $this->activeFilters = array_filter($this->activeFilters, fn($filter) => $filter !== $filterString);

        $this->resetPage();
    }

    public function render(): mixed
    {
        //query utama
        $query = Kegiatan::with('latestProgress', 'program.bidang', 'dusun', 'laporan');

        // Filter berdasarkan Bidang
        if ($this->selectedBidang) {
            $query->whereHas('program.bidang', function ($q) {
                $q->where('id', $this->selectedBidang);
            });
        }

        // Filter berdasarkan Dusun
        if ($this->selectedDusun) {
            $query->whereHas('dusun', function ($q) {
                $q->where('id', $this->selectedDusun);
            });
        }

        // Filter berdasarkan Status
        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);;
        }

        //filter berdasarkan Tahun
        if ($this->selectedYear) {
            $query->where('tahun_' . $this->selectedYear, true);
        }

        // Filter berdasarkan Search
        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }

        $kegiatans = $query->paginate(5);

        // data untuk peta
        $this->setupDataMaps($kegiatans);

        // Menambahkan progres terakhir ke dalam array headers untuk setiap kegiatan
        foreach ($kegiatans as $kegiatan) {
            $kegiatan->latest_progres = $kegiatan->latestProgress->progres ?? '0'; // Nilai default 0 jika tidak ada laporan
        }

        return view('livewire.index', [
            'kegiatans' => $kegiatans,
        ]);
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedBidang = null;
        $this->selectedDusun = null;
        $this->selectedStatus = null;
        $this->selectedYear = null;
        $this->activeFilters = [];
        $this->resetPage(); // Kembali ke halaman pertama
    }

    public function searchKegiatan()
    {
        $this->resetPage(); // Reset ke halaman pertama

        // Jika input kosong, reset pencarian
        if (trim($this->search) === '') {
            $this->search = '';
        }

        // Panggil ulang setupDataMaps untuk memperbarui dataMap
        $query = Kegiatan::with('latestProgress', 'program.bidang', 'dusun', 'laporan');
        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }
        $kegiatans = $query->get();
        $this->setupDataMaps($kegiatans);

        // Render ulang data
        $this->render();
    }

    // Fungsi untuk memilih kegiatan dan menampilkan detailnya
    public function selectKegiatan($id)
    {
        $this->selectedKegiatan = Kegiatan::with(['dusun', 'laporan', 'program.bidang'])->find($id);
        $this->setupDetailKegiatan();
        $this->selectedDetail = [
            'id' => $this->selectedKegiatan->id,
            'nama' => $this->selectedKegiatan->nama,
            'longitude' => $this->selectedKegiatan->longitude,
            'latitude' => $this->selectedKegiatan->latitude,
            'bidang_nama' => $this->selectedKegiatan->program->bidang->nama ?? 'Tidak Ada Bidang',
        ];
        $this->showDetail = !$this->showDetail;
    }

    public function setupDataMaps($data)
    {
        $this->dataMap = $data
            ->map(function ($kegiatan) {
                return [
                    'id' => $kegiatan->id,
                    'nama' => $kegiatan->nama,
                    'longitude' => $kegiatan->longitude,
                    'latitude' => $kegiatan->latitude,
                    'bidang_nama' => $kegiatan->program->bidang->nama ?? 'Tidak Ada Bidang',
                ];
            })
            ->toArray();
    }

    public function getShowDetailProperty()
    {
        return !is_null($this->selectedKegiatan);
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
                'data' => $this->selectedKegiatan->laporan->isNotEmpty() ? $this->selectedKegiatan->laporan->last()->progres . '%' : '0%',
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
                'data' => $this->selectedKegiatan->volume . ' ' . $this->selectedKegiatan->satuan,
            ],
            [
                'name' => 'Tahun',
                'data' => ($this->selectedKegiatan->tahun_1 ? '1, ' : '') . ($this->selectedKegiatan->tahun_2 ? '2, ' : '') . ($this->selectedKegiatan->tahun_3 ? '3, ' : '') . ($this->selectedKegiatan->tahun_4 ? '4, ' : '') . ($this->selectedKegiatan->tahun_5 ? '5, ' : '') . ($this->selectedKegiatan->tahun_6 ? '6' : ''),
            ],
            [
                'name' => 'Lokasi',
                'data' => $this->selectedKegiatan->lokasi,
            ],
            [
                'name' => 'Koordinat',
                'data' => $this->selectedKegiatan->latitude . ', ' . $this->selectedKegiatan->longitude,
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
    <div class="p-4 overflow-auto">
        {{-- Component Search --}}
        <div class="flex justify-center mb-4">
            <x-card class="w-full h-fit">
                <input type="text" class="w-full rounded-md shadow-sm form-input" icon="o-magnifying-glass" placeholder="Cari kegiatan..."
                wire:model.debounce.300ms="search" wire:keydown.enter="searchKegiatan">
            </x-card>
        </div>
        {{-- Component Informasi Filters --}}
        <div class="flex items-center">
            <div class="flex flex-wrap gap-2">
                @foreach ($activeFilters as $filter)
                    <span class="inline-flex items-center px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">
                        {{ $filter }}
                        <button
                            wire:click="removeFilter('{{ $filter }}')"
                            class="ml-2 text-red-500 hover:text-red-700"
                        >
                            &times;
                        </button>
                    </span>
                @endforeach
            </div>
        </div>
        {{-- Component Data Tables --}}
        <table class="table mb-4">
            <thead>
                <tr>
                    <th></th>
                    <th>Kegiatan</th>
                    <th>Dusun</th>
                    <th>Progress</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kegiatans as $row)
                    <tr class="hover">
                        <th>{{ $loop->index + $kegiatans->firstItem() }}</th>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->dusun->nama }}</td>
                        <td>{{ $row->latest_progres }}%</td>
                        <th>
                            <button class="btn btn-ghost btn-xs" wire:click="selectKegiatan({{ $row->id }})">
                                Details
                            </button>
                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Maaf, data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Component Paginations --}}
        <div class="flex items-center">
            <p class="flex-grow text-sm opacity-80">
                <b>{{ $kegiatans->firstItem() }} - {{ $kegiatans->lastItem() }}</b> dari
                <b>{{ $kegiatans->total() }}</b>
            </p>
            <div class="join">
                <button class="join-item btn btn-xs" wire:click="gotoPage(1, 'page')">
                    << </button>
                        <button class="join-item btn btn-xs" wire:click="previousPage('page')">
                            < </button>
                                <button class="join-item btn btn-xs">Page {{ $kegiatans->currentPage() }}</button>
                                <button class="join-item btn btn-xs" wire:click="nextPage('page')"> > </button>
                                <button class="join-item btn btn-xs" wire:click="gotoPage({{ $kegiatans->lastPage() }}, 'page')"> >> </button>
            </div>
        </div>
        <x-menu-separator />
        <div class="flex items-center grid-cols-3 gap-2 mt-6">
            <p class="col-span-2 mr-5 text-sm text-right text-gray-500">Started Build 28 Oct 2024 with Tall Stack & Mary UI</p>
            <div class="col-span-1 justify-items-end">
                <button wire:click="resetFilters" class="btn btn-sm btn-outline">Reset Filter</button>
            </div>
        </div>
    </div>

    <!-- Bagian Card (4 dari 12 kolom), ditampilkan berdasarkan showDetail -->
    @if ($showDetail)
        <div class="p-4 overflow-auto bg-base-200">
            <!-- Detail Kegiatan -->
            <div class="flex items-center mb-4">
                <h2 class="font-bold text-md">Detail Kegiatan {{ $selectedKegiatan->nama }}</h2>
                <x-button icon="m-pencil-square"
                    link="{{ route('edit-kegiatan', ['kegiatan' => $selectedKegiatan->id]) }}" spinner
                    class="ml-2 btn-sm btn-ghost" />
            </div>

            <div class="flex flex-col">
                <table class="table">
                    <tbody>
                        @foreach ($detailKegiatan as $d)
                            <tr>
                                <td class="p-0 opacity-60">{{ $d['name'] }}</td>
                                <td class="p-0">: {{ $d['data'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Laporan Kegiatan -->
            <div class="flex my-4">
                <h2 class="font-bold text-md">Laporan Kegiatan</h2>
                <x-button icon="o-plus"
                    link="{{ route('add-laporan', [
                        'selectedBidang' => $selectedKegiatan->program->bidang->id,
                        'selectedProgram' => $selectedKegiatan->program->id,
                        'selectedKegiatan' => $selectedKegiatan->id,
                    ]) }}"
                    class="col-span-1 ml-2 justify-content-center h-fit btn-square btn-xs btn-outline" />
            </div>
            <ul class="timeline timeline-vertical">
                @foreach ($selectedKegiatan->laporan as $laporan)
                    <li>
                        <hr />
                        <div class="text-right timeline-start">
                            {{ $laporan->progres }}%
                            <p class="opacity-80">{{ $laporan->created_at->format('d-M-Y H:i') }}</p>
                        </div>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="timeline-end">
                            <div class="flex items-center">
                                <span class="font-bold">{{ $laporan->judul }}</span>
                                <x-button icon="m-pencil-square"
                                    link="{{ route('edit-laporan', ['laporan' => $laporan->id]) }}" spinner
                                    class="ml-2 btn-sm btn-ghost" />
                            </div>
                            <p class="opacity-80">{{ $laporan->deskripsi }}</p>
                        </div>
                        <hr />
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Bagian Map (5 dari 12 kolom) -->
    <div class="{{ $showDetail ? 'col-span-1' : 'col-span-2' }}" did="peta-wrap">
        <div wire:ignore class="w-full h-full" id="peta"></div>
    </div>
</div>

@script
    <script>


        mapboxgl.accessToken =
            'pk.eyJ1IjoidmFuc2VsaXRlMjEiLCJhIjoiY20yeWd2dDZyMDB3MjJtc2piZjE1ZDk0OSJ9.yDmaTMSvuPWK-iDhvldKWg';

        const map = new mapboxgl.Map({
            container: 'peta', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
            center: [110.3002315278843, -7.970304705716586], // starting position [lng, lat]
            zoom: 13, // starting zoom
        });

        const warnaBidang = {
            'Pendidikan': '#40e0d0',
            'Kesehatan': '#b4c6d0',
            'Penataan Ruang': '#4a8bad',
            'Kawasan Pemukiman': '#ffff00',
            'Lingkungan Hidup': '#00ff00',
            'Perhubungan dan Infokom': '#e23a08',
            'Pariwisata': '#492971',
            'Default': '#42f545',
        };

        const createMarker = (coordinate, map, color, title) => {
            return new mapboxgl.Marker({
                    color: color
                })
                .setPopup(new mapboxgl.Popup().setText(title))
                .setLngLat(coordinate)
                .addTo(map);
        };

        let kegiatanMarkers = [];
        let selectedMarker = null;

        function clearMarkers(markers) {
            markers.forEach(marker => marker.remove());
            markers.length = 0; // Clear the array
        };

        function fitMarkersToBounds(dataMap, map) {
            if (dataMap.length === 0) return;

            // Ambil semua koordinat dari dataMap
            const coordinates = dataMap.map(kegiatan => [kegiatan.longitude, kegiatan.latitude]);

            // Panggil fitBounds dengan bounding box yang mencakup semua koordinat
            map.fitBounds(coordinates, {
                padding: 50, // Padding di sekitar bounds dalam piksel
                maxZoom: 13, // Zoom maksimal
                duration: 500, // Durasi animasi dalam milidetik
            });
        };

        function renderMarkers(dataMap, map) {
            clearMarkers(kegiatanMarkers);
            kegiatanMarkers = dataMap.map(kegiatan => createMarker(
                [kegiatan.longitude, kegiatan.latitude],
                map,
                warnaBidang[kegiatan.bidang_nama] || warnaBidang['Default'],
                kegiatan.nama
            ));

            // Pusatkan peta pada semua marker
            fitMarkersToBounds(dataMap, map);

            window.kegiatanMarkers = kegiatanMarkers;
        };

        function renderSelectedMarker(selectedKegiatan, map) {
            clearMarkers(kegiatanMarkers); // Remove all markers from renderMarkers
            if (selectedMarker) {
                selectedMarker.remove(); // Remove existing selectedMarker if any
            }

            if (selectedKegiatan) {
                selectedMarker = createMarker(
                    [selectedKegiatan.longitude, selectedKegiatan.latitude],
                    map,
                    warnaBidang[selectedKegiatan.bidang_nama] || warnaBidang['Default'],
                    selectedKegiatan.nama
                );
                const currentZoom = map.getZoom();
                map.flyTo({
                    center: [selectedKegiatan.longitude, selectedKegiatan.latitude],
                    minzoom: currentZoom - 3,
                    offset: [-225, -10],
                    duration: 500,
                });
            }
        };

        Livewire.hook('morph.updated', ({
            el,
            component
        }) => {
            if (el.getAttribute('did') == 'peta-wrap') {
                const dataMap = $wire.get('dataMap');
                const selectedKegiatan = $wire.get('selectedDetail');
                const showDetail = $wire.get('showDetail');

                if (showDetail) {
                    // Render only the selected marker
                    renderSelectedMarker(selectedKegiatan, map);
                    console.log(selectedKegiatan);
                } else {
                    // Revert to rendering all markers
                    if (selectedMarker) {
                        selectedMarker.remove();
                        selectedMarker = null;
                    }
                    renderMarkers(dataMap, map);
                };

                // window.kegiatanMarkers.map(r => r.remove())
                // let dataMap = $wire.get('dataMap');
                // renderMarkers(dataMap, map);
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('removeFilter', (filterString) => {
                Livewire.emit('removeFilter', filterString);
            });
        });

        let dataMap = $wire.get('dataMap');
        renderMarkers(dataMap, map);
    </script>
@endscript
