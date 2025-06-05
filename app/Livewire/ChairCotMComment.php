<?php

namespace App\Livewire;

use App\Models\CotMComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChairCotMComment extends Component
{
    public $isOpen = false;

    public $syll_co_out_id;
    public $cot_m_comment_text;

    public $cot_m_comment_id;
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
        $comment = new CotMComment();
        $comment->syll_co_out_id = $this->syll_co_out_id;
        $comment->cot_m_comment_text = $this->cot_m_comment_text;
        $comment->user_id = Auth::id();
        $comment->cot_m_comment_created_at = now();
        $comment->save();

        $this->cot_m_comment_text = '';
    }
    public function resolveComment($cot_m_comment_id)
    {
        $comment = CotMComment::find($cot_m_comment_id);

        if ($comment) {
            if ($comment->cot_m_comment_resolved_at) {
                $comment->cot_m_comment_resolved_at = null;
                session()->flash('success', 'Comment unresolved successfully.');
            } else {
                $comment->cot_m_comment_resolved_at = now();
                session()->flash('success', 'Comment resolved successfully.');
            }
            $comment->save();
        } else {
            session()->flash('error', 'Comment not found.');
            dd($cot_m_comment_id);
        }
    }
    public function render()
    {
        $cot_m_comments = CotMComment::join('users', 'users.id', '=', 'cot_m_comments.user_id')
            ->where('cot_m_comments.syll_co_out_id', $this->syll_co_out_id)
            ->where('cot_m_comments.user_id', Auth::id())
            ->select('cot_m_comments.*', 'users.*')
            ->get();

        $unresolvedComments = $cot_m_comments->whereNull('cot_m_comment_resolved_at')->count();

        return view('livewire.bl-cot-m-comment', [
            'cot_m_comments' => $cot_m_comments,
    'unresolvedComments' => $unresolvedComments]);
    }
}
