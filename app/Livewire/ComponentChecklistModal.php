<?php

namespace App\Livewire;

use Livewire\Component;

class ComponentChecklistModal extends Component
{
    public bool $isOpen = false;
    public ?array $item = null;
    public array $components = [];
    public bool $hasMissingIssue = false;
    public string $missingNote = '';
    public bool $confirmed = false;

    protected $listeners = [
        'open-checklist' => 'open',
    ];

    public function open(array $itemData): void
    {
        $this->item = $itemData;
        $this->isOpen = true;
        $this->hasMissingIssue = false;
        $this->missingNote = '';
        $this->confirmed = false;

        if (($itemData['type'] ?? '') === 'book') {
            $this->components = [
                ['id' => 1, 'name' => 'Cover Depan & Belakang Utuh (Bebas Lipatan Ekstrem)', 'checked' => false, 'critical' => true],
                ['id' => 2, 'name' => 'Halaman Lengkap (Cek Sampul 1 - Akhir)', 'checked' => false, 'critical' => true],
                ['id' => 3, 'name' => 'Bebas Noda Basah / Tinta Spidol Tebal', 'checked' => false, 'critical' => true],
                ['id' => 4, 'name' => '1x Pembatas Buku Pita Kain Asli', 'checked' => false, 'critical' => false],
            ];
        } else {
            $this->components = [
                ['id' => 1, 'name' => '2x Dadu Kayu Berbintik Enam', 'checked' => false, 'critical' => true],
                ['id' => 2, 'name' => '1x Papan Lipat Hexagon (Tebal & Rata)', 'checked' => false, 'critical' => true],
                ['id' => 3, 'name' => '96x Kartu Permainan (Sleeved / Plastik Rapi)', 'checked' => false, 'critical' => true],
                ['id' => 4, 'name' => '16x Token Kayu & Miniatur Rumah', 'checked' => false, 'critical' => false],
                ['id' => 5, 'name' => '1x Buku Panduan Lembar Aturan Cetak', 'checked' => false, 'critical' => false],
            ];
        }
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function toggleComponent(int $id): void
    {
        foreach ($this->components as &$comp) {
            if ($comp['id'] === $id) {
                $comp['checked'] = !$comp['checked'];
                break;
            }
        }
    }

    public function getIsAllCheckedProperty(): bool
    {
        foreach ($this->components as $comp) {
            if (!$comp['checked']) return false;
        }
        return true;
    }

    public function getCanSubmitProperty(): bool
    {
        if ($this->isAllChecked) return true;
        if ($this->hasMissingIssue && strlen(trim($this->missingNote)) >= 5) return true;
        return false;
    }

    public function confirmVerification(): void
    {
        if (!$this->canSubmit) return;

        $this->confirmed = true;
        $this->dispatch('checklist-verified', [
            'item_id' => $this->item['id'] ?? null,
            'status' => $this->hasMissingIssue ? 'VERIFIKASI_DENGAN_CATATAN' : 'KOMPONEN_LENGKAP_100',
            'note' => $this->missingNote,
        ]);
    }

    public function render()
    {
        return view('livewire.component-checklist-modal');
    }
}

