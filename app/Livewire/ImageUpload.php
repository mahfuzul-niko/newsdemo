<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

class ImageUpload extends Component
{

    use WithFileUploads;

    public $avatar;


    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:10000', // Perform validation on change
        ]);
        $this->uploadAvatar();
    }
    public function uploadAvatar()
    {

        if (Storage::exists(auth()->user()->avatar)) {
            Storage::delete(auth()->user()->avatar);
        }
        // Store the uploaded image in a temporary location
        $image = $this->avatar->store('avatars', 'public');




        // Save the resized image path to the user's avatar field
        auth()->user()->update([
            'avatar' => $image,
        ]);

        // Optionally: if the user already has an avatar, you can delete the old one
        // Storage::disk('public')->delete(auth()->user()->avatar);

        session()->flash('message', 'Avatar uploaded successfully!');
    }
    public function render()
    {
        return view('livewire.image-upload');
    }
}
