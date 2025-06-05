<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminUserTable extends Component
{
    use WithPagination;
    public $search = '';
    public $roles_filters;
    public function render()
    {
        $users = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
        ->where(function($query){
            $query->where('users.id', 'like', '%' . $this->search . '%')
            ->orWhere('users.firstname', 'like', '%' . $this->search . '%')
            ->orWhere('users.lastname', 'like', '%' . $this->search . '%')
            ->orWhere('users.email', 'like', '%' . $this->search . '%')
            ->orWhere('users.password', 'like', '%' . $this->search . '%')
            ->orWhere('users.firstname', 'like', '%' . $this->search . '%')
            ->orWhere('users.lastname', 'like', '%' . $this->search . '%')
            ->orWhere('users.prefix', 'like', '%' . $this->search . '%')
            ->orWhere('users.suffix', 'like', '%' . $this->search . '%')
            ->orWhere('users.phone', 'like', '%' . $this->search . '%');
        })
        ->when($this->roles_filters, function ($query) {
            $query->where('user_roles.role_id', 'like', '%' .$this->roles_filters);
        })
        ->distinct()
            ->select('users.*')
            ->paginate(10);
        return view('livewire.admin-user-table', ['users' => $users]);
    }
    public function applyFilters()
    {
        $this->resetPage();
    }
}
