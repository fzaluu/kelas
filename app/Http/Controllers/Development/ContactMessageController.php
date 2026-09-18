<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContactMessageController extends Controller
{
    private function getTableName(): string
    {
        if (Schema::hasTable('feedback_messages')) {
            return 'feedback_messages';
        }
        if (Schema::hasTable('feedbacks')) {
            return 'feedbacks';
        }
        if (Schema::hasTable('messages')) {
            return 'messages';
        }

        return 'feedback_messages';
    }

    public function index(Request $request)
    {
        $tableName = $this->getTableName();
        $messages = collect();

        if (Schema::hasTable($tableName)) {
            $messages = DB::table($tableName)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('pages.development.public.messages.index', compact('messages'));
    }

    public function destroy($id)
    {
        $tableName = $this->getTableName();

        if (Schema::hasTable($tableName)) {
            DB::table($tableName)->where('id', $id)->delete();
        }

        return redirect()->route('development.public.messages.index')
            ->with('success', 'Pesan masukan berhasil dihapus.');
    }
}