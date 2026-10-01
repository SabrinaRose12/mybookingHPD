{{-- Shared form partial — Modern Light --}}

{{-- Room Name --}}
<div>
    <label for="name" class="block text-sm font-bold text-[#334155] mb-2">
        Room Name <span class="text-red-500">*</span>
    </label>
    <input type="text" id="name" name="name"
           value="{{ old('name', $room->name ?? '') }}"
           required maxlength="255"
           placeholder="e.g., Dewan Mutiara"
           class="auth-input pl-4 pr-4 {{ $errors->has('name') ? 'is-error' : '' }}">
    @error('name')
        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
    @enderror
</div>

{{-- Capacity --}}
<div>
    <label for="capacity" class="block text-sm font-bold text-[#334155] mb-2">
        Capacity <span class="text-red-500">*</span>
    </label>
    <input type="number" id="capacity" name="capacity"
           value="{{ old('capacity', $room->capacity ?? '') }}"
           required min="1"
           placeholder="e.g., 30"
           class="auth-input pl-4 pr-4 {{ $errors->has('capacity') ? 'is-error' : '' }}">
    @error('capacity')
        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
    @enderror
</div>

{{-- PIC --}}
<div>
    <label for="pic" class="block text-sm font-bold text-[#334155] mb-2">
        Unit/Dept in Charge <span class="text-[#94a3b8] font-medium">(optional)</span>
    </label>
    <input type="text" id="pic" name="pic"
           value="{{ old('pic', $room->pic ?? '') }}"
           maxlength="255"
           placeholder="Management Unit"
           class="auth-input pl-4 pr-4">
    @error('pic')
        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
    @enderror
</div>

{{-- PIC Email --}}
<div>
    <label for="pic_email" class="block text-sm font-bold text-[#334155] mb-2">
        Unit/Dept Email <span class="text-[#94a3b8] font-medium">(optional)</span>
    </label>
    <input type="email" id="pic_email" name="pic_email"
           value="{{ old('pic_email', $room->pic_email ?? '') }}"
           placeholder="adminhpd@moh.gov.my"
           class="auth-input pl-4 pr-4">
    @error('pic_email')
        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
    @enderror
</div>

{{-- Building --}}
<div>
    <label for="building" class="block text-sm font-bold text-[#334155] mb-2">
        Building <span class="text-[#94a3b8] font-medium">(optional)</span>
    </label>
    <input type="text" id="building" name="building"
           value="{{ old('building', $room->building ?? '') }}"
           maxlength="255"
           placeholder="e.g., Kompleks Pengurusan"
           class="auth-input pl-4 pr-4">
    @error('building')
        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
    @enderror
</div>

{{-- Description --}}
<div>
    <label for="description" class="block text-sm font-bold text-[#334155] mb-2">
        Description <span class="text-[#94a3b8] font-medium">(optional)</span>
    </label>
    <textarea id="description" name="description" rows="3"
              placeholder="Describe the room facilities, equipment, etc."
              class="auth-input pl-4 pr-4 resize-none">{{ old('description', $room->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
    @enderror
</div>

{{-- Active Toggle --}}
<div class="flex items-center gap-3 p-4 bg-[#fafbff] border border-[#eef1f8] rounded-xl">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" id="is_active" name="is_active" value="1"
           {{ old('is_active', isset($room) ? $room->is_active : true) ? 'checked' : '' }}
           class="h-5 w-5 rounded border-[#cbd2e0] text-purple-600 cursor-pointer accent-purple-600">
    <label for="is_active" class="text-sm font-bold text-[#334155] cursor-pointer">
        Room is active (visible to users for booking)
    </label>
</div>

{{-- Images Upload --}}
<div class="pt-4 border-t border-[#eef1f8]">
    <label for="images" class="block text-sm font-bold text-[#334155] mb-2">
        Upload Images <span class="text-[#94a3b8] font-medium">(optional, multiple allowed)</span>
    </label>
    <input type="file" id="images" name="images[]" multiple accept="image/*"
           class="block w-full text-sm text-[#64748b]
                  file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                  file:text-sm file:font-bold file:bg-purple-100 file:text-purple-700
                  hover:file:bg-purple-200 file:transition-colors
                  cursor-pointer bg-[#fafbff] rounded-xl border border-[#e2e7f0]">
    <p class="mt-2 text-xs text-[#94a3b8] font-medium">Max size: 2MB · JPG, PNG, WebP</p>
    @error('images.*')
        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
    @enderror

    @if(isset($room) && $room->images && count($room->images) > 0)
        <div class="mt-6">
            <h4 class="text-xs font-bold text-[#94a3b8] uppercase tracking-widest mb-3">Current Images</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($room->images as $imagePath)
                    <div class="relative group aspect-video rounded-xl bg-[#fafbff] border border-[#eef1f8] overflow-hidden">
                        <img src="{{ $room->imageUrl($imagePath) }}" alt="Room Image" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-[#0f1419]/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button type="button"
                                    onclick="if(confirm('Delete this image?')) { document.getElementById('delete-image-{{ $loop->index }}').submit(); }"
                                    class="bg-red-500 hover:bg-red-600 text-white p-2.5 rounded-xl shadow-lg transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>