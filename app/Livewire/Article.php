<?php

namespace App\Livewire;

use App\Enums\PostStatusEnum;
use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;

class Article extends Component
{
    public $slug;
    public $article;

    public $commentName = '';
    public $commentEmail = '';
    public $commentMessage = '';
    public $privacyConsent = false;

    protected $rules = [
        'commentName' => 'required|string|min:2|max:100',
        'commentEmail' => 'required|email|max:255',
        'commentMessage' => 'required|string|min:10|max:500',
        'privacyConsent' => 'accepted',
    ];

    protected $messages = [
        'commentName.required' => 'Please enter your name.',
        'commentName.min' => 'Name must be at least 2 characters.',
        'commentName.max' => 'Name cannot exceed 100 characters.',
        'commentEmail.required' => 'Please enter your email address.',
        'commentEmail.email' => 'Please enter a valid email address.',
        'commentMessage.required' => 'Please enter your comment.',
        'commentMessage.min' => 'Comment must be at least 10 characters.',
        'commentMessage.max' => 'Comment cannot exceed 500 characters.',
        'privacyConsent.accepted' => 'Please accept the privacy policy.',
    ];

    public function mount($slug)
    {
        $this->slug = $slug;

        $this->article = Post::with(['author', 'category', 'tags', 'comments'])
            ->where('slug', $slug)
            ->where('status', PostStatusEnum::PUBLISHED->value)
            ->firstOrFail();
    }

    public function submitComment()
    {
        try {
            $this->validate();

            $comment = Comment::create([
                'post_id' => $this->article->id,
                'name' => trim($this->commentName),
                'email' => trim($this->commentEmail),
                'message' => trim($this->commentMessage),
            ]);

            $this->reset([
                'commentName',
                'commentEmail',
                'commentMessage',
                'privacyConsent'
            ]);

            $this->refreshArticle();

            session()->flash('success', 'Thank you! Your comment has been posted successfully.');

            $this->dispatch('commentPosted');
        } catch (\Exception $e) {
            session()->flash('error', 'There was an error posting your comment. Please try again.');
        }
    }

    public function refreshComments()
    {
        $this->refreshArticle();
    }

    private function refreshArticle()
    {
        $this->article = Post::with(['author', 'category', 'tags', 'comments'])
            ->where('slug', $this->slug)
            ->where('status', PostStatusEnum::PUBLISHED->value)
            ->firstOrFail();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.article')
            ->layout('components.layouts.app', ['title' => $this->article->title ?? 'Article Not Found']);
    }
}
