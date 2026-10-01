{{-- Shared form partial for create & edit user — Modern Light --}}

<style>
    .switch { position: relative; display: inline-block; width: 52px; height: 28px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd2e0; transition: .3s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 4px; bottom: 4px; background-color: white; transition: .3s; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
    input:checked + .slider { background: linear-gradient(135deg, #7c3aed, #6366f1); }
    input:checked + .slider:before { transform: translateX(24px); }
</style>

{{-- Name --}}
<div>
    <label for="name" class="block text-sm font-bold text-[#334155] mb-2">Name <span class="text-red-500">*</span></label>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required maxlength="255"
           placeholder="e.g., Ahmad Fauzi"
           class="auth-input pl-4 pr-4 {{ $errors->has('name') ? 'is-error' : '' }}">
    @error('name')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
</div>

{{-- Email --}}
<div>
    <label for="email" class="block text-sm font-bold text-[#334155] mb-2">Email <span class="text-red-500">*</span></label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
           placeholder="user@moh.gov.my"
           class="auth-input pl-4 pr-4 {{ $errors->has('email') ? 'is-error' : '' }}">
    @error('email')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
</div>

{{-- Phone --}}
<div>
    <label for="phone" class="block text-sm font-bold text-[#334155] mb-2">Phone Number <span class="text-red-500">*</span></label>
    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required
           placeholder="0123456789"
           class="auth-input pl-4 pr-4 {{ $errors->has('phone') ? 'is-error' : '' }}">
    @error('phone')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
</div>

{{-- Office Ext --}}
<div>
    <label for="office_no" class="block text-sm font-bold text-[#334155] mb-2">Ext <span class="text-[#94a3b8] font-medium">(optional)</span></label>
    <input type="text" id="office_no" name="office_no" value="{{ old('office_no', $user->office_no ?? '') }}"
           placeholder="301"
           class="auth-input pl-4 pr-4">
    @error('office_no')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
</div>

{{-- Password --}}
<div>
    <label for="password" class="block text-sm font-bold text-[#334155] mb-2">
        {!! $user ? 'New Password <span class="text-[#94a3b8] font-medium">(optional)</span>' : 'Password <span class="text-red-500">*</span>' !!}
    </label>
    <input type="password" id="password" name="password" {{ $user ? '' : 'required' }}
           placeholder="{{ $user ? 'Leave blank to keep current' : 'Min. 8 characters' }}"
           class="auth-input pl-4 pr-4 {{ $errors->has('password') ? 'is-error' : '' }}">
    @error('password')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
</div>

{{-- Is Admin Toggle --}}
<div class="flex items-center gap-3 p-4 bg-purple-50 border border-purple-200 rounded-xl">
    <input type="hidden" name="is_admin" value="0">
    <input type="checkbox" id="is_admin" name="is_admin" value="1"
           {{ old('is_admin', isset($user) ? $user->is_admin : false) ? 'checked' : '' }}
           onchange="toggleAdminFields(this.checked)"
           class="h-5 w-5 rounded border-purple-300 text-purple-600 cursor-pointer accent-purple-600">
    <label for="is_admin" class="text-sm font-bold text-purple-800 cursor-pointer">
        This user is an Admin (PIC Bilik)
    </label>
</div>

{{-- Assigned Rooms --}}
<div id="assigned-rooms-section" style="{{ old('is_admin', isset($user) ? $user->is_admin : false) ? '' : 'display: none;' }}" class="mt-4 pt-4 border-t border-[#eef1f8]">
    <label class="block text-sm font-bold text-[#334155] mb-2">
        Assigned Rooms <span class="text-red-500">*</span>
        <span class="text-[#94a3b8] text-xs font-medium block mt-1">Select which rooms this admin can manage</span>
    </label>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 bg-[#fafbff] rounded-xl p-4 border border-[#eef1f8] max-h-60 overflow-y-auto">
        @foreach($rooms as $room)
            <label class="flex items-center gap-2.5 p-2.5 rounded-lg hover:bg-purple-50 transition-colors cursor-pointer border border-transparent hover:border-purple-200">
                <input type="checkbox" name="assigned_rooms[]" value="{{ $room->id }}"
                       {{ in_array($room->id, old('assigned_rooms', isset($user) ? $user->assigned_rooms ?? [] : [])) ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-[#cbd2e0] text-purple-600 cursor-pointer accent-purple-600">
                <span class="text-sm font-medium text-[#334155]">
                    {{ $room->name }}
                    <span class="text-xs text-[#94a3b8] block font-normal">{{ $room->building ?? 'No building' }}</span>
                </span>
            </label>
        @endforeach
    </div>
    @error('assigned_rooms')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
</div>

{{-- Description --}}
<div>
    <label for="description" class="block text-sm font-bold text-[#334155] mb-2">Description <span class="text-[#94a3b8] font-medium">(optional)</span></label>
    <textarea id="description" name="description" rows="3" placeholder="User's department, office location, etc."
              class="auth-input pl-4 pr-4 resize-none">{{ old('description', $user->description ?? '') }}</textarea>
    @error('description')<p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
</div>

{{-- Active Toggle --}}
<div class="flex items-center justify-between p-4 bg-[#fafbff] border border-[#eef1f8] rounded-xl">
    <div>
        <p class="text-sm font-bold text-[#334155]">Account Status</p>
        <p class="text-xs text-[#94a3b8] mt-0.5 font-medium">Toggle to activate or deactivate this account</p>
    </div>
    <label class="switch">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', isset($user) ? $user->is_active : true) ? 'checked' : '' }}>
        <span class="slider"></span>
    </label>
</div>

<script>
    function toggleAdminFields(isAdmin) {
        const section = document.getElementById('assigned-rooms-section');
        if (isAdmin) section.style.display = 'block';
        else { section.style.display = 'none'; document.querySelectorAll('input[name="assigned_rooms[]"]').forEach(cb => cb.checked = false); }
    }
</script>