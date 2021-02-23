<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Message;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function message()
    {
    	return view('message.message', [
    		'messages' => Message::all()
    	]);
    }

    public function sendMessage(Request $request)
    {
    	$request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        // print_r($request->except('_token'));
        $contact_id = Message::insertGetId($request->except('_token') + [
            'created_at' => Carbon::now()
        ]);
        if ($request->hasFile('attachment_file')) {
            // $path = $request->file('attachment_file')->store('contact_attachment');
            $path = $request->file('attachment_file')->storeAs(
                'contact_attachment', $contact_id.".".$request->file('attachment_file')->getClientOriginalExtension()
            );
            Message::find($contact_id)->update([
                'attachment_file' => $path
            ]);
        }

        return back()->with('message_success', 'Message send successfully. We will contact you as soon as possible.');
    }

    public function attachmentDownload($msg_id)
    {
        return Storage::download(Message::findOrFail($msg_id)->attachment_file);
    }
}
