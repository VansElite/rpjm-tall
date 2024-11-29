<?php

use App\Models\Kegiatan;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Bidang;
use App\Models\Dusun;


new class extends Component {
    use WithPagination;

    public array $activeFilters = []; //properti untuk menyimpan filter yang aktif
    public $selectedBidang;
    public $selectedDusun;
    public $selectedStatus;
    public $selectedYear;

    protected $listeners = [
        'filter-updated' => 'applyFilter'
    ];

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
    ];

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'nama', 'label' => 'Nama Kegiatan'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'latest_progres', 'label' => 'Progres'],
    ];

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

        $kegiatans = $query->paginate(10);

        // Menambahkan progres terakhir ke dalam array headers untuk setiap kegiatan
        foreach ($kegiatans as $kegiatan) {
            $kegiatan->latest_progres = $kegiatan->latestProgress->progres ?? '0'; // Nilai default 0 jika tidak ada laporan
        }

        return view('livewire.direktori-kegiatan', [
            'kegiatans' => $kegiatans,
        ]);
    }

    public function edit($id)
    {
        return to_route('edit-kegiatan', $id);
    }

    public function delete($id)
    {
        Kegiatan::destroy($id);
        return to_route('direktori-kegiatan');
    }

}; ?>

<div>
    <x-card title="Data Kegiatan RPJM Tirtomulyo" class="flex mx-3 my-3 bg-base-200 rounded-xl" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo">
        <div class="flex items-center mb-5">
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
        <x-table :headers="$headers" :rows="$kegiatans" with-pagination show-empty-text empty-text="Maaf, data tidak ditemukan.">
        {{-- Special `actions` slot --}}
            @scope('cell_latest_progres', $kegiatans)
            <p>{{ $kegiatans->latest_progres ?? '0' }}%</p>
            @endscope
            @scope('actions', $kegiatan)
            <div class="flex gap-2">
                {{-- <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm"/> --}}
                <x-button icon="o-pencil-square" wire:click="edit({{ $kegiatan->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $kegiatan->id }})" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
