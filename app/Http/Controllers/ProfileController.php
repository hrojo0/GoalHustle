<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Request $request, Profile $profile)
    {
        
        $user = Auth::user();
        $profile = $user->profile;
        
        $articles = Article::where([['user_id', $profile->user_id], ['status', '1']])
                            ->simplePaginate(8);
        return view('profile.show', compact('profile', 'articles'));
    }
    public function show(Profile $profile)
    {
        
        $articles = Article::where([['user_id', $profile->user_id], ['status', '1']])
                            ->simplePaginate(8);
        return view('profile.show', compact('articles', 'profile'));
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, Profile $profile)
    {
        /*ORIGINAL
        return view('profile.edit', [
            'user' => $request->user(),
        ]);*/

        $user = $request->user();
        $profile = $user->profile;
        $this->authorize('view', $profile);
        return view('profile.edit', compact('user', 'profile'));
        
    }

    /**
     * Update the user's profile information.
     */
    //ORIGINALpublic function update(ProfileUpdateRequest $request): RedirectResponse
    public function update(ProfileRequest $request, Profile $profile)
    {
        /*
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');*/

        //$user = Auth::user();
        $user = User::find(Auth::id());
        $profile = $request->user()->profile;

        $this->authorize('update', $profile);
        if ($request->hasFile('photo'))
        {
            //Eliminar foto anterior
            File::delete(public_path('storage/'.$profile->photo));
            //Asginar una nueva foto
            $photo = $request['photo']->store('profiles');
        } else {
            
            $photo = $user->profile->photo;
        }

        //asignar nombre y correo
        $user->name = $request->name;
        $user->email = $request->email;
        //asignar foto
        $user->profile->photo = $photo;

        $user->save();//Guarda campos de usuario
        $user->profile->save();//Guarda campos del perfil

        return redirect()->route('profile.edit', $user->profile->id)->with('status', 'profile-updated');;
        
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
