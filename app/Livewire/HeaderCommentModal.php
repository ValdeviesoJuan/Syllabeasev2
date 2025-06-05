<?php

namespace App\Livewire;
use App\Models\HeaderComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class HeaderCommentModal extends Component
{ 
    public $isOpen = false;

    public $syll_id;
    public $header_comment_text;

    public $header_comment_id;
    public $commentResolved = false;
    public function openComments()
    {
        $this->isOpen = true;
    }
    public function closeComments()
    {
        $this->isOpen = false;
    }

    public function addComment()
    {
        $comment = new HeaderComment();
        $comment->syll_id = $this->syll_id;
        $comment->header_comment_text = $this->header_comment_text;
        $comment->user_id = Auth::id();
        $comment->header_comment_created_at = now();
        $comment->save();

        $this->header_comment_text = '';
    }
    public function resolveComment($header_comment_id)
    {
        $comment = HeaderComment::find($header_comment_id);

        if ($comment) {
            if ($comment->header_comment_resolved_at) {
                $comment->header_comment_resolved_at = null;
                session()->flash('success', 'Comment unresolved successfully.');
            } else {
                $comment->header_comment_resolved_at = now();
                session()->flash('success', 'Comment resolved successfully.');
            }
            $comment->save();
        } else {
            session()->flash('error', 'Comment not found.');
            dd($header_comment_id);
        }
    }
    public function render()
    {
        $header_comments = HeaderComment::join('users', 'users.id', '=', 'header_comments.user_id')
            ->where('header_comments.syll_id', $this->syll_id)
            ->select('header_comments.*', 'users.*')
            ->get();

        $unresolvedComments = $header_comments->whereNull('header_comment_resolved_at')->count();

        return view('livewire.header-comment', [
            'header_comments' => $header_comments,
    'unresolvedComments' => $unresolvedComments]);
    }
}
