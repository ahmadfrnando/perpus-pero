<!-- resources/views/filament/pages/laporan-peminjaman.blade.php -->
<x-filament::page>
    <x-filament-panels::form wire:submit="cetak">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </x-filament-panels::form>
</x-filament::page>
