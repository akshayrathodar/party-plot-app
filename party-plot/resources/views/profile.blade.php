@extends('layouts.admin')
@section('content')
    <x-top-header title="Update Profile"/>
    
    <form action="{{ route('profile.update') }}" method="POST" id="my-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-6">                       
                <div class="card pb-0">
                    <div class="card-body">
                        {{-- <h5 class="mb-4">Profile Information</h5> --}}
                        {{-- <form action="{{ route('profile.update') }}" enctype="multipart/form-data" method="POST"> --}}
                            <div class="m-auto profile-image-section position-relative mb-3">
                                @csrf
                                @if (isset($user->staff_photo) && file_exists(public_path('uploads/staffs/'.$user->staff_photo)))
                                    <img src="{{ asset('uploads/staffs/'.$user->staff_photo) }}" alt="User profile picture">
                                @else
                                    <img src="{{ asset('uploads/staffs/default.png') }}" alt="User profile picture">
                                @endif
                                <input type="file" name="staff_photo" id="staff_photo" class="no-preview" onchange="this.form.submit()" accept="Image/*" style="display:none"/>
                                <button type="button" id="imgupload" class="btn btn-info btn-sm position-absolute top-0 end-0 p-2"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
                            </div>
                        {{-- </form> --}}
                        <div class="row">
                            <div class="col-6">
                                <x-input label="Name" name="name" :value="$user->name" required="true"/>
                            </div>
                            <div class="col-6">
                                <x-input label="Username" name="username" :value="$user->username" required="true"/>
                            </div>
                            <div class="col-6">
                                <x-input label="Email" name="email" :value="$user->email" required="true"/>
                            </div>
                            <div class="col-6">
                                <x-input label="Mobile" name="mobile" :value="$user->mobile" required="true"/>
                            </div>
                            <div class="col-12">
                                <x-textarea label="Address" name="address" :value="$user->address" required="true"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <form action="{{ route('profile.update') }}" method="POST" id="my-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card pb-0">
                        <div class="card-body">
                            <h5 class="mb-4">Update Password</h5>
                            <div class="row">
                                <div class="col-12">
                                    <x-password label="Password" name="password"/>
                                </div>
                                <div class="col-12">
                                    <x-password label="Confirm Password" name="confirm_password" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#imgupload').click(function() {
                $('#staff_photo').click();
            });
        });
    </script>
@endsection