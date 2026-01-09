<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\User;

#[Layout('components.layouts.landing')]
class DoctorPage extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::doctors()->with('doctorDetail');

        if ($this->search) {
            $terms = preg_split('/\s+/', trim($this->search));

            foreach ($terms as $term) {
                $t = '%' . $term . '%';
                $query->where(function ($q) use ($t) {
                    $q->where('name', 'like', $t)
                      ->orWhere('email', 'like', $t)
                      ->orWhere('contact', 'like', $t)
                      ->orWhereHas('doctorDetail', function ($dq) use ($t) {
                          $dq->where('specialization', 'like', $t)
                             ->orWhere('description', 'like', $t)
                             ->orWhere('license_number', 'like', $t)
                             ->orWhere('address', 'like', $t)
                             ->orWhere('experience_years', 'like', $t);
                      });
                });
            }
        }

        $doctors = $query->orderBy('name')->paginate(12);

        return view('livewire.landing.doctor-page', compact('doctors'));
    }
}
