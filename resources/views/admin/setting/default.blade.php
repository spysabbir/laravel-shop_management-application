@extends('admin.layouts.admin_master')

@section('title', 'Default Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Default Setting</h4>
                <p class="card-text">Update</p>
            </div>
            <div class="card-body">
                <form action="{{ route('default.setting.update', $default_setting->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="favicon">Favicon</label>
                            <input id="favicon" class="form-control" type="file" name="favicon" />
                            @error('favicon')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="logo_photo">Logo Photo</label>
                            <input id="logo_photo" class="form-control" type="file" name="logo_photo" />
                            @error('logo_photo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4 col-12 mb-3">
                            <label class="form-label" for="app_name">App Name</label>
                            <input id="app_name" class="form-control" type="text" name="app_name" value="{{ $default_setting->app_name }}" />
                            @error('app_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-12 mb-3">
                            <label class="form-label" for="app_url">App Url</label>
                            <input id="app_url" class="form-control" type="text" name="app_url" value="{{ $default_setting->app_url }}" />
                            @error('app_url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label">Time Zone</label>
                            <select class="form-select" name="time_zone">
                                <option value="UTC" @selected($default_setting->time_zone == 'UTC')>UTC</option>
                                <option value="Asia/Dhaka" @selected($default_setting->time_zone == 'Asia/Dhaka')>Asia/Dhaka</option>
                                <option value="America/New_York" @selected($default_setting->time_zone == 'America/New_York')>America/New_York</option>
                            </select>
                            @error('time_zone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="main_phone">Mail Phone</label>
                            <input id="main_phone" class="form-control" type="text" name="main_phone" value="{{ $default_setting->main_phone }}" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="support_phone">Support Phone</label>
                            <input id="support_phone" class="form-control" type="text" name="support_phone" value="{{ $default_setting->support_phone }}" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="main_email">Main Email</label>
                            <input id="main_email" class="form-control" type="text" name="main_email" value="{{ $default_setting->main_email }}" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="support_email">Support Email</label>
                            <input id="support_email" class="form-control" type="text" name="support_email" value="{{ $default_setting->support_email }}" />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="address">Address</label>
                            <input id="address" class="form-control" type="text" name="address" value="{{ $default_setting->address }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="facebook_link">Facebook Link</label>
                            <input id="facebook_link" class="form-control" type="text" name="facebook_link" value="{{ $default_setting->facebook_link }}" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="twitter_link">Twitter Link</label>
                            <input id="twitter_link" class="form-control" type="text" name="twitter_link" value="{{ $default_setting->twitter_link }}" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="instagram_link">Instagram Link</label>
                            <input id="instagram_link" class="form-control" type="text" name="instagram_link" value="{{ $default_setting->instagram_link }}" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="linkedin_link">Linkedin Link</label>
                            <input id="linkedin_link" class="form-control" type="text" name="linkedin_link" value="{{ $default_setting->linkedin_link }}" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="youtube_link">Youtube Link</label>
                            <input id="youtube_link" class="form-control" type="text" name="youtube_link" value="{{ $default_setting->youtube_link }}" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
