@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Setting')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Setting: {{ $setting->key }}</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.settings.update', $setting) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="key" class="form-label">Key <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="key" name="key" value="{{ old('key', $setting->key) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="value" class="form-label">Value</label>
                        <textarea class="form-control" id="value" name="value" rows="3">{{ old('value', $setting->value) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="text" {{ old('type', $setting->type) == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="boolean" {{ old('type', $setting->type) == 'boolean' ? 'selected' : '' }}>Boolean</option>
                            <option value="json" {{ old('type', $setting->type) == 'json' ? 'selected' : '' }}>JSON</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="group" class="form-label">Group <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="group" name="group" value="{{ old('group', $setting->group) }}" list="groups" required>
                        <datalist id="groups">
                            @foreach($groups as $group)
                                <option value="{{ $group }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
