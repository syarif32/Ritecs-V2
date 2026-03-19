<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use Exception;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::latest()->get();
        return view('backend.pages.comments.index', [
            'title' => 'Data Komentar',
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return view('backend.pages.comments.edit', [
            'title' => 'Balas Komentar',
            'comment' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        
        
        $request->validate([
            'status' => 'required|in:pending,approved,spam',
        ]);

       
        $comment->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.comments.index')->with('success', 'Status komentar berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil dihapus!');
    }

    /**
     * Update only the status of the comment.
     */
    public function updateStatus(Request $request, Comment $comment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,spam',
        ]);

        $comment->update(['status' => $request->status]);

        return redirect()->route('admin.comments.index')->with('success', 'Status komentar berhasil diperbarui!');
    }
    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'reply_message' => 'required|string',
        ]);


        $data = [
            'name' => $comment->name,
            'reply_message' => $request->reply_message,
            'original_message' => $comment->message
        ];

        Mail::send('pages.emails.reply', $data, function($message) use ($comment) {
            $message->to($comment->email, $comment->name)
                    ->subject('Balasan Pesan dari Ritecs');
        });

       
        $comment->update([
            'status' => 'approved'
        ]);

        return redirect()->route('admin.comments.index')
            ->with('success', 'Balasan terkirim dan status otomatis diperbarui menjadi Approved!');
    }
}