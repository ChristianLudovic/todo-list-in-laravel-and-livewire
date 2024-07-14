<?php

namespace App\Livewire\Pages;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TodoList extends Component
{
    public $isDialogOpen = false;
    public $isConnexionOpen = false;
    public $tasks;
    public $title;
    public $description;
    public $completed;
    public $isEditing = false;
    public $editingTaskId;
    public $taskToggled = false;
    public $searchTerm = '';
    public $users;
    public $isMenuOpen = false;

    public function deleteTask(Task $task)
    {
        $task->delete();
        $this->tasks = Task::latest()->get();
    }

    public function editTask(Task $task)
{
    if ($task->user_id === auth()->id()) {
        $this->title = $task->title;
        $this->description = $task->description;
        $this->completed = $task->completed;
        $this->isDialogOpen = true;
        $this->isEditing = true;
        $this->editingTaskId = $task->id;
    }
}

    protected $rules = [
        'title' => 'required|min:3|max:200|regex:/^[\pL\s\-]+$/u',
        'description' => 'required'
    ];

    protected $listeners = ['closeDialog', 'taskAdded' => 'refreshTasks'];

    public function mount()
    {
        $this->refreshTasks();
    }

    public function openDialog()
    {
        $this->isDialogOpen = true;
    }

    public function closeDialog()
    {
        $this->isDialogOpen = false;
        $this->reset(['title', 'description', 'isEditing', 'editingTaskId']);
    }

    public function openConnexion()
    {
        $this->isConnexionOpen = true;
    }

    public function closeConnexion()
    {
        $this->isConnexionOpen = false;
    }

    public function toggleMenu()
    {
        $this->isMenuOpen = !$this->isMenuOpen;
    }

    public function closeMenu()
    {
        $this->isMenuOpen = false;
    }

    public function refreshTasks()
    {
        $this->tasks = Task::where('user_id', auth()->id())
                        ->where(function ($query) {
                            $query->where('title', 'like', '%' . $this->searchTerm . '%')
                                    ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
                        })
                        ->latest()
                        ->get();
    }

    public function addTask()
    {
        if ($this->isEditing) {
            $this->updateTask();
        } else {
            Task::create([
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => auth()->id(),
            ]);
        }

        $this->reset(['title', 'description', 'isEditing', 'editingTaskId']);
        $this->dispatch('taskAdded');
        $this->closeDialog();
    }

    public function updateTask()
    {
        $task = Task::where('id', $this->editingTaskId)
                    ->where('user_id', auth()->id())
                    ->first();

        if ($task) {
            $task->update([
                'title' => $this->title,
                'description' => $this->description,
            ]);
        }

        $this->reset(['title', 'description', 'isEditing', 'editingTaskId']);
        $this->refreshTasks();
    }

    public function toggleTaskStatus(Task $task)
    {
        $task->update([
            'completed' => !$task->completed
        ]);

        $this->taskToggled = true;
        $this->tasks = Task::latest()->get();

    }

    public function updatedSearchTerm()
    {
        $this->refreshTasks();
    }

    public function redirectToProvider($provider)
    {
        return redirect()->route('socialite.redirect', ['provider' => $provider]);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.pages.todo-list');
    }
}