<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request): Response
    {
        $users = UserResource::collection(User::paginate($request->per_page ?? 6));

        return Inertia::render('User/Index', ['users' => $users]);
    }

    public function create(): Response
    {
        return Inertia::render('User/Create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageService->optimizeImage($request->file('image'));
        }

        User::create($validated);

        return Redirect::route('users.index');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('User/Edit', ['user' => $user]);
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The password is incorrect.']);
        }

        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', Password::defaults(), 'confirmed']
        ]);

        $user->update(['password' => Hash::make($validated['password']),]);

        return Redirect::route('users.index');
    }

    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = public_path($user->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $validated['image'] = $this->imageService->optimizeImage($request->file('image'));
        }

        $user->update($validated);

        return Redirect::route('users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::back();
    }
}
