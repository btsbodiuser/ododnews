<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BannedIp;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $query = Comment::with('article', 'user')->latest();

        if (in_array($status, ['pending', 'approved', 'rejected', 'spam'], true)) {
            $query->where('status', $status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('body', 'like', "%{$request->search}%")
                  ->orWhere('author_name', 'like', "%{$request->search}%")
                  ->orWhere('author_email', 'like', "%{$request->search}%");
            });
        }

        $comments = $query->paginate(20)->withQueryString();
        $counts = Comment::select('status', DB::raw('count(*) as c'))->groupBy('status')->pluck('c', 'status');

        return view('admin.comments.index', compact('comments', 'status', 'counts'));
    }

    public function update(Request $request, Comment $comment)
    {
        $action = $request->input('action');
        match ($action) {
            'approve' => $comment->update(['status' => 'approved']),
            'reject'  => $comment->update(['status' => 'rejected']),
            'spam'    => $comment->update(['status' => 'spam']),
            default   => null,
        };
        ActivityLog::record("comment.$action", $comment, "Сэтгэгдлийг $action хийсэн");
        return back()->with('success', 'Сэтгэгдлийн төлвийг өөрчиллөө.');
    }

    public function bulk(Request $request)
    {
        $request->validate([
            'ids'    => 'required|array',
            'action' => 'required|in:approve,reject,spam,delete',
        ]);
        $ids = $request->input('ids');
        if ($request->action === 'delete') {
            Comment::whereIn('id', $ids)->delete();
        } else {
            $status = ['approve' => 'approved', 'reject' => 'rejected', 'spam' => 'spam'][$request->action];
            Comment::whereIn('id', $ids)->update(['status' => $status]);
        }
        ActivityLog::record("comment.bulk.{$request->action}", null, count($ids).' сэтгэгдэл');
        return back()->with('success', count($ids).' сэтгэгдэлд үйлдэл хийгдлээ.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        ActivityLog::record('comment.deleted', $comment, 'Сэтгэгдэл устгасан');
        return back()->with('success', 'Сэтгэгдэл устгагдлаа.');
    }

    public function banIp(Comment $comment)
    {
        if ($comment->author_ip) {
            BannedIp::firstOrCreate(['ip' => $comment->author_ip], ['reason' => 'Spam comments']);
            Comment::where('author_ip', $comment->author_ip)->update(['status' => 'spam']);
        }
        return back()->with('success', 'IP хаягийг хорилоо.');
    }
}
