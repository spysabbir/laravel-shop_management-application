
@extends('admin.layouts.admin_master')

@section('title', 'Sms Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Sms Setting</h4>
                <p class="card-text">Update</p>
            </div>
            <div class="card-body">
                <form action="{{ route('sms.setting.update', $sms_setting->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="mailer">Mailer</label>
                            <input id="mailer" class="form-control" type="text" name="mailer" value="{{ $sms_setting->mailer }}" />
                            @error('mailer')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="host">Host</label>
                            <input id="host" class="form-control" type="text" name="host" value="{{ $sms_setting->host }}" />
                            @error('host')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
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
