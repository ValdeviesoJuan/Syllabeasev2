<?php

namespace App\Livewire;

use App\Models\TosComment as ModelsTosComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChairTosAComment extends Component
{ 
    public $isOpen = false;

    public $tos_id;
    public $tos_comment_text;
    public $col_no;

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
        $comment = new ModelsTosComment();
        $comment->tos_id = $this->tos_id;
        $comment->col_no = $this->col_no;
        $comment->tos_comment_text = $this->tos_comment_text;
        $comment->user_id = Auth::id();
        $comment->tos_comment_created_at = now();
        $comment->save();

        $this->tos_comment_text = '';
    }
    public function resolveComment($header_comment_id)
    {
        $comment = ModelsTosComment::find($header_comment_id);

        if ($comment) {
            if ($comment->tos_comment_resolved_at) {
                $comment->tos_comment_resolved_at = null;
                session()->flash('success', 'Comment unresolved successfully.');
            } else {
                $comment->tos_comment_resolved_at = now();
                session()->flash('success', 'Comment resolved successfully.');
            }
            $comment->save();
        } else {
            session()->flash('error', 'Comment not found.');
        }
    }
    public function render()
    {
        $tos_comments = ModelsTosComment::join('users', 'users.id', '=', 'tos_comments.user_id')
            ->where('tos_comments.tos_id', $this->tos_id)
            ->where('tos_comments.user_id', Auth::user()->id)
            ->where('tos_comments.col_no', $this->col_no)
            ->select('tos_comments.*', 'users.*')
            ->get();

        $unresolvedComments = $tos_comments->whereNull('tos_comment_resolved_at')->count();

        return view('livewire.tos-a-comment', [
            'tos_comments' => $tos_comments,
    'unresolvedComments' => $unresolvedComments]);
    }
}
