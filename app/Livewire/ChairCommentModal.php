<?php

namespace App\Livewire;

use App\Models\COComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChairCommentModal extends Component
{
    public $isOpen = false;

    public $syll_co_id;
    public $co_comment_text;

    public $co_comment_id;
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
        $comment = new COComment();
        $comment->syll_co_id = $this->syll_co_id;
        $comment->co_comment_text = $this->co_comment_text;
        $comment->user_id = Auth::id();
        $comment->co_comment_created_at = now();
        $comment->save();

        $this->co_comment_text = '';
    }
    public function resolveComment($co_comment_id)
    {
        $comment = COComment::find($co_comment_id);

        if ($comment) {
            if ($comment->co_comment_resolved_at) {
                $comment->co_comment_resolved_at = null;
                session()->flash('success', 'Comment unresolved successfully.');
            } else {
                $comment->co_comment_resolved_at = now();
                session()->flash('success', 'Comment resolved successfully.');
            }
            $comment->save();
        } else {
            session()->flash('error', 'Comment not found.');
            dd($co_comment_id);
        }
    }
    public function render()
    {
        $co_comments = COComment::join('users', 'users.id', '=', 'co_comments.user_id')
            ->where('co_comments.syll_co_id', $this->syll_co_id)
            ->where('co_comments.user_id', Auth::id())
            ->select('co_comments.*', 'users.*')
            ->get();

        $unresolvedComments = $co_comments->whereNull('co_comment_resolved_at')->count();

        return view('livewire.bl-comment-modal', [
            'co_comments' => $co_comments,
    'unresolvedComments' => $unresolvedComments]);
    }
}
