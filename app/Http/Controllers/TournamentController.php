<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\IdeaStore;
use Illuminate\Support\Facades\Mail;

class TournamentController extends Controller
{

    public function index()
    {
        $perticipants = User::where('eliminated',0)->get();
        if($perticipants->count() == 8){
            session()->put('tournament',1);
        }
        return view('welcome',compact('perticipants'));
    }

    public function storeIdea(IdeaStore $request)
    {
        User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'idea'  => $request->idea
        ]);

        return back()->with('success','Idea submitted successfully');
    }

    public function elimination()
    {
        $perticipants = User::query()->where('eliminated',0);
        $count = $perticipants->count();
        if($count != 1){
            $take = $count/2;
            $perticipants->inRandomOrder()->take($take)->update(['eliminated' => 1]);
        }
        $perticipants->get()->map(function($winner){
            Mail::to($winner->email)->send(new \App\Mail\Winner());
        });
        return response()->json(['winner' => true]);
    }

    public function newTournament()
    {
        $winner = User::where('eliminated',0)->firstOrFail();
        $winner->eliminated = 1;
        $winner->update();
        session()->forget('tournament');
        return back();
    }
}
