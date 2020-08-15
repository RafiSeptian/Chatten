<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\User;
use App\Events\MessageSent;
use App\Libs\Response;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    protected $user;
    protected $token;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware(['apiToken']);

        $this->token = request('token');
        $this->user = User::whereLoginToken($this->token)->first();
    }

    public function index()
    {
        // get all contact without im
        $users = User::where('login_token', '!=', $this->token)->orWhere('login_token', null)->get();

        return Response::success(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'from' => $this->user->id,
            'to' => $request->to,
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return Response::success(['msg' => 'Message has been sent']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $messages = DB::table('message_users')->where('from', $this->user->id)->where('to', $id)->orWhere('from', $id)->where('to', $this->user->id)->orderBy('created_at', 'asc')->get();

        return Response::success(['messages' => $messages, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('message_users')->where('id', $id)->delete();

        return Response::success(['msg' => 'Message has been deleted']);
    }
}
