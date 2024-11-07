<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <x-nav sticky full-width>
        <x-slot:brand>
            {{-- Brand --}}
            <x-app-brand class="mr-8 max-h-12" />

            <x-dropdown label="Bidang" no-x-anchor class="mx-1 btn-ghost btn-md" responsive>
                <x-menu-item title="Pendidikan" />
                <x-menu-item title="Kesehatan" />
                <x-menu-item title="Pekerjaan Umum & Penataan Ruang" />
                <x-menu-item title="Kawasan Pemukiman" />
                <x-menu-item title="Kehutanan dan Lingkungan Hidup" />
                <x-menu-item title="Perhub dan Infokom" />
                <x-menu-item title="Pariwisata" />
            </x-dropdown>
            <x-dropdown label="Dusun" no-x-anchor class="mx-1 btn-ghost btn-md" responsive>
                <x-menu-item title="Plesan" />
                <x-menu-item title="Paliyan" />
                <x-menu-item title="Karen" />
                <x-menu-item title="Gondangan" />
                <x-menu-item title="Kergan" />
                <x-menu-item title="Bracan" />
                <x-menu-item title="Tokolan" />
            </x-dropdown>
            <x-dropdown label="Status" no-x-anchor class="mx-1 btn-ghost btn-md" responsive>
                <x-menu-item title="Selesai" />
                <x-menu-item title="Sedang Berjalan" />
                <x-menu-item title="Direncanakan" />
            </x-dropdown>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            <x-button label="Dashboard" icon="s-book-open" link="###" class="btn-ghost" responsive />
            <x-button label="User Management" icon="o-user-group" link="###" class="btn-ghost" responsive />
            <x-dropdown>
                <x-slot:trigger>
                    <x-button label="Guest" icon="o-user" class="btn-outline" responsive />
                </x-slot:trigger>
                <x-menu-item title="log in" icon="o-arrow-left-end-on-rectangle" />
                <x-menu-item title="log out" icon="o-arrow-right-start-on-rectangle" />
            </x-dropdown>
        </x-slot:actions>
    </x-nav>
</div>
