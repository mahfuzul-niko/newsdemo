<div>

    <div class="profile-image position-relative">
        <img wire:loading.remove wire:target="avatar"
            src="{{ $avatar ? $avatar->temporaryUrl() : auth()->user()->getAvatar() }}" alt=""
            class="avatar-xl rounded-circle">
        <img wire:loading wire:target="avatar" src="{{ asset('assets/kOnzy.gif') }}" alt=""
            class="avatar-xl rounded-circle">
        <button onclick="document.getElementById('avatar').click()" class="btn-none"
            style="position: absolute;bottom:10px;"><i class="fa fa-image"></i></button>
        <input wire:model.debounce.500ms="avatar" type="file" class="d-none" id="avatar" accept="image/*">


        <!-- Loading spinner -->

    </div>
    <small wire:target="avatar" wire:loading>
        Uploading...
    </small>
</div>
