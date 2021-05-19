<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

use RealRashid\SweetAlert\Facades\Alert;

use App\Models\User;


class EventController extends Controller
{
    
    public function index(){

        $search = request('search');

        if($search){

            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();

        }else{

            $events = Event::all();

        }

        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create(){
        return view('events.create');
    }

    public function store(Request $request){

        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        // Image upload
        if($request->hasFile('image') && $request->file('image')->isValid()){

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;

        }

        $user = auth()->user();
        $event->user_id = $user->id;

        if(!empty($json["error_list"])){
            $json["status"] = 0;
        }
        else{
            if(empty($event->title)){
                $json["error_list"]["#title"] = "Nome é obrigatório!";
                toast('Nome do evento é obrigatório!','error');
            }
            elseif(empty($event->city)){
                $json["error_list"]["#city"] = "Cidade é obrigatório!";
                toast('Cidade é obrigatório!','error');
            }
            elseif(empty($event->description)){
                $json["error_list"]["#description"] = "Descrição é obrigatório!";
                toast('Descrição é obrigatório!','error');
            }
            else{

                $event->save();
                Alert::success('Successo', 'Cadastro efetuado.');

            }
    
        }
        return redirect('/events/create');
        // echo json_encode($json);
    }

    public function show($id){

        $user = auth()->user();

        $hasUserJoined = false;

        if($user) {

            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent) {
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }
            }

        }
        
        $event = Event::findOrFail($id);

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show' , ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' =>$hasUserJoined]);
    }

    public function dashboard(){
        
        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]);
    }

    public function destroy($id) {

        Event::findOrFail($id)->delete();

        Alert::success('Successo', 'Evento deletado.');

        return redirect('/dashboard');
    }

    public function edit($id) {

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if($user->id != $event->user_id) {

            return redirect('/dashboard');

        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request) {

        $data = $request->all();

            // Image upload
            if($request->hasFile('image') && $request->file('image')->isValid()){

                $requestImage = $request->image;
        
                $extension = $requestImage->extension();
        
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
        
                $requestImage->move(public_path('img/events'), $imageName);
        
                $data['image'] = $imageName;
        
            }

        Event::findOrFail($request->id)->update($data);

        Alert::success('Successo', 'Evento editado.');

        return redirect('/dashboard');
    }

    public function joinEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        Alert::success('Successo', 'Presença confirmada.');

        return redirect('/');
    }

    public function leaveEvent ($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        if($event = Event::findOrFail($id)){

            Alert::success('Successo', 'Você saiu do evento '.$event->title);

            return redirect('/dashboard');

        }

    }
}
