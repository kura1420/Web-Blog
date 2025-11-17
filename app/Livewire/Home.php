<?php

namespace App\Livewire;

use App\Enums\PostStatusEnum;
use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Home extends Component
{
    use WithPagination;

    #[Url(as: 'search')]
    public $searchQuery = '';

    #[Url(as: 'category')]
    public $selectedCategory = '';

    public $perPage = 6;

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->reset(['searchQuery', 'selectedCategory']);
        $this->resetPage();
    }

    public function selectCategory($categoryName)
    {
        $this->selectedCategory = $categoryName;
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::with(['author', 'category', 'tags'])
            ->where('status', PostStatusEnum::PUBLISHED->value);

        if ($this->searchQuery) {
            $searchTerm = '%' . $this->searchQuery . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'ilike', "%{$searchTerm}%");
            });
        }

        if ($this->selectedCategory) {
            $query->whereHas('category', function ($categoryQuery) {
                $categoryQuery->where('name', $this->selectedCategory);
            });
        }

        $posts = $query->latest('published_at')->paginate($this->perPage);

        $popularCategories = Category::withCount('posts')
            ->limit(4)
            ->pluck('name')
            ->toArray();

        return view('livewire.home', [
            'posts' => $posts,
            'popularCategories' => $popularCategories,
        ])
            ->layout('components.layouts.app', ['title' => 'Home']);
    }
}
