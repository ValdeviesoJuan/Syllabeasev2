<?php

namespace App\Livewire;

use App\Models\CotFComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChairCotFComment extends Component
{
    public $isOpen = false;

    public $syll_co_out_id;
    public $cot_f_comment_text;

    public $cot_f_comment_id;
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
        $comment = new CotFComment();
        $comment->syll_co_out_id = $this->syll_co_out_id;
        $comment->cot_f_comment_text = $this->cot_f_comment_text;
        $comment->user_id = Auth::id();
        $comment->cot_f_comment_created_at = now();
        $comment->save();

        $this->cot_f_comment_text = '';
    }
    public function resolveComment($cot_f_comment_id)
    {
        $comment = CotFComment::find($cot_f_comment_id);

        if ($comment) {
            if ($comment->cot_f_comment_resolved_at) {
                $comment->cot_f_comment_resolved_at = null;
                session()->flash('success', 'Comment unresolved successfully.');
            } else {
                $comment->cot_f_comment_resolved_at = now();
                session()->flash('success', 'Comment resolved successfully.');
            }
            $comment->save();
        } else {
            session()->flash('error', 'Comment not found.');
            dd($cot_f_comment_id);
        }
    }
    public function render()
    {
        $cot_f_comments = CotFComment::join('users', 'users.id', '=', 'cot_f_comments.user_id')
            ->where('cot_f_comments.syll_co_out_id', $this->syll_co_out_id)
            ->where('cot_f_comments.user_id', Auth::id())
            ->select('cot_f_comments.*', 'users.*')
            ->get();

        $unresolvedComments = $cot_f_comments->whereNull('cot_f_comment_resolved_at')->count();

        return view('livewire.bl-cot-f-comment', [
            'cot_f_comments' => $cot_f_comments,
    'unresolvedComments' => $unresolvedComments]);
    }
}
