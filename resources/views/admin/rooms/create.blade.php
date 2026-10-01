@extends('layouts.app')
@section('title', $room ? 'Edit Room: ' . $room->name : 'Add New Room')

@section('content')

    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-purple-600 hover:text-purple-700 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Back to Room Listings
        </a>
    </div>

    <div class="mb-10 animate-fade-in-up">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-purple-500/10 to-indigo-500/10 border border-purple-500/20 text-xs font-semibold text-purple-700 mb-4">
            <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>
            {{ $room ? 'Editing' : 'Creating' }}
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-[#0f1419]">
            {{ $room ? 'Edit' : 'Add New' }} <span class="text-gradient-blue">Room</span>
        </h1>
        <p class="mt-2 text-sm text-[#64748b]">
            {!! $room ? 'Updating: <span class="font-bold text-[#0f1419]">' . $room->name . '</span>' : 'Fill in the details below to add a new room.' !!}
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-5 rounded-2xl bg-red-50 border border-red-200 animate-fade-in-up">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 border border-red-200 flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-red-800">Please fix the errors below.</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ $room ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data"
          class="modern-card p-8 space-y-6 animate-fade-in-up">
        @csrf
        @if($room)
            @method('PUT')
        @endif

        @include('admin.rooms._form', ['room' => $room ?? null])

        <div class="flex gap-3 pt-4 border-t border-[#eef1f8]">
            <button type="submit" class="btn-modern btn-primary flex-1">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ $room ? 'Save Changes' : 'Create Room' }}
            </button>
            <a href="{{ route('admin.rooms.index') }}" class="btn-modern btn-secondary">Cancel</a>
        </div>
    </form>

    @if(isset($room) && $room->images && count($room->images) > 0)
        @foreach($room->images as $imagePath)
            <form id="delete-image-{{ $loop->index }}" action="{{ route('admin.rooms.image.delete', $room) }}" method="POST" class="hidden">
                @csrf @method('DELETE')
                <input type="hidden" name="image_path" value="{{ $imagePath }}">
            </form>
        @endforeach
    @endif

@endsection