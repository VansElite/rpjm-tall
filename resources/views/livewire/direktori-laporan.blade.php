<?php
use App\Models\Laporan;
use App\Models\Bidang;
use App\Models\Dusun;
use Livewire\Volt\Component;
use Livewire\WithPagination;

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

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'kegiatan.nama', 'label' => 'Nama Kegiatan'],
        ['key' => 'judul', 'label' => 'Judul Laporan'],
        ['key' => 'progres', 'label' => 'Progres Laporan'],
        ['key' => 'deskripsi', 'label' => 'Deskripsi'], // Masih ada kekurangan, progres ambil dari laporan
    ];

    public function render(): mixed
    {
         //query utama
         $query = Laporan::with('kegiatan.program.bidang', 'kegiatan.dusun');

        // Filter berdasarkan Bidang
        if ($this->selectedBidang) {
            $query->whereHas('kegiatan.program.bidang', function ($q) {
                $q->where('id', $this->selectedBidang);
            });
        }

        // Filter berdasarkan Dusun
        if ($this->selectedDusun) {
            $query->whereHas('kegiatan.dusun', function ($q) {
                $q->where('id', $this->selectedDusun);
            });
        }

        // Filter berdasarkan Status
        if ($this->selectedStatus) {
            $query->whereHas('kegiatan.status', function ($q) {
                $q->where('status', $this->selectedStatus);
            });
        }

        //filter berdasarkan Tahun
        if ($this->selectedYear) {
            $query->whereHas('kegiatan.status', function ($q) {
                $q->where('tahun_' . $this->selectedYear, true);
            });
        }

        $laporans = $query->paginate(10);

        return view('livewire.direktori-laporan', [
            'laporans' => $laporans, // Menggunakan paginate
        ]);
    }

    public function edit($id)
    {
        return to_route('edit-laporan', $id);
    }

    public function delete($id)
    {
        $laporan = Laporan::find($id);
        $kegiatan = $laporan->kegiatan;
        // dd($kegiatan);
        Laporan::destroy($id);
        $progres = $kegiatan->latestProgress->progres;
        if ($progres === 0) {
            $kegiatan->update([
                'status' => 'direncanakan',
            ]);
            $kegiatan->save();
        }elseif ($progres === 100) {
            $kegiatan->update([
                'status' => 'selesai',
            ]);
            $kegiatan->save();
        }else {
            if ($kegiatan->status !== 'sedangBerjalan') {
                $kegiatan->update([
                    'status' => 'sedangBerjalan',
                ]);
                $kegiatan->save();
            }
        };
        return to_route('direktori-laporan');
    }
}; ?>

<div>
    <x-card title="Data Laporan RPJM Tirtomulyo" class="flex mx-3 my-3 bg-base-200 rounded-xl" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo" separator>
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
        <x-table :headers="$headers" :rows="$laporans" with-pagination show-empty-text empty-text="Maaf, data tidak ditemukan.">
            {{-- Special `actions` slot --}}
                @scope('actions', $laporan)
                <div class="flex gap-2">
                    {{-- <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm" /> --}}
                    <x-button icon="o-pencil-square" wire:click="edit({{ $laporan->id }})" spinner class="btn-sm" />
                    <x-button icon="o-trash" wire:click="delete({{ $laporan->id }})" spinner class="btn-sm" />
                </div>
                @endscope
            </x-table>
            </x-card>
</div>
