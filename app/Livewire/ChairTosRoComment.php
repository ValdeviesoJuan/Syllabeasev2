<?php

namespace App\Livewire;

use App\Models\TosRowComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChairTosRoComment extends Component
{
    public $isOpen = false;

    public $tos_r_id;
    public $tos_r_comment_text;
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
        $comment = new TosRowComment();
        $comment->tos_r_id = $this->tos_r_id;
        $comment->col_no = $this->col_no;
        $comment->tos_r_comment_text = $this->tos_r_comment_text;
        $comment->user_id = Auth::id();
        $comment->tos_r_comment_created_at = now();
        $comment->save();

        $this->tos_r_comment_text = '';
    }
    public function resolveComment($tos_r_comment_id)
    {
        $comment = TosRowComment::find($tos_r_comment_id);

        if ($comment) {
            if ($comment->tos_r_comment_resolved_at) {
                $comment->tos_r_comment_resolved_at = null;
                session()->flash('success', 'Comment unresolved successfully.');
            } else {
                $comment->tos_r_comment_resolved_at = now();
                session()->flash('success', 'Comment resolved successfully.');
            }
            $comment->save();
        } else {
            session()->flash('error', 'Comment not found.');
        }
    }
    public function render()
    {
        $tos_row_comments = TosRowComment::join('users', 'users.id', '=', 'tos_row_comments.user_id')
            ->where('tos_row_comments.tos_r_id', $this->tos_r_id)
            ->where('tos_row_comments.user_id', Auth::user()->id)
            ->where('tos_row_comments.col_no', $this->col_no)
            ->select('tos_row_comments.*', 'users.*')
            ->get();

        $unresolvedComments = $tos_row_comments->whereNull('tos_r_comment_resolved_at')->count();
        return view('livewire.tos-ro-comment', [
            'tos_row_comments' => $tos_row_comments,
    'unresolvedComments' => $unresolvedComments]);
    }
}
