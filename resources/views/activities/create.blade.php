@extends('layouts.dashboard')
@section('title', 'Log Activity')
@section('header', 'Log Activity')

@section('content')
<style>
.frm-input, .frm-textarea, .frm-select {
    width:100%; padding:0.7rem 1rem; border-radius:0.5rem; font-size:0.875rem;
    background-color:#0A1628; border:1.5px solid #253548; color:#F1F5F9;
    outline:none; transition:border-color 0.2s, box-shadow 0.2s;
    -webkit-text-fill-color:#F1F5F9; font-family:inherit;
}
.frm-input::placeholder, .frm-textarea::placeholder { color:#64748B; }
.frm-input:focus, .frm-textarea:focus, .frm-select:focus { border-color:#22D3EE; box-shadow:0 0 0 3px rgba(34,211,238,0.12); }
.frm-input:-webkit-autofill, .frm-input:-webkit-autofill:focus {
    -webkit-box-shadow:0 0 0 1000px #0A1628 inset; -webkit-text-fill-color:#F1F5F9;
}
.frm-label { display:block; font-size:0.8125rem; font-weight:500; margin-bottom:0.5rem; color:#CBD5E1; }
.frm-hint { font-size:0.75rem; margin-top:0.375rem; color:#64748B; }
</style>

<div class="max-w-2xl mx-auto">
    <div class="rounded-2xl overflow-hidden" style="background:linear-gradient(145deg,#1A2A3F,#152030); border:1px solid #253548; box-shadow:0 8px 32px rgba(0,0,0,0.4);">

        <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #253548; background:rgba(0,0,0,0.2);">
            <a href="{{ route('activities.index') }}"
               class="p-1.5 rounded-lg transition-colors" style="color:#64748B;"
               onmouseover="this.style.backgroundColor='#253548'; this.style.color='#E2E8F0'"
               onmouseout="this.style.backgroundColor='transparent'; this.style.color='#64748B'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(34,211,238,0.15); border:1px solid rgba(34,211,238,0.3);">
                    <svg class="w-4 h-4" style="color:#22D3EE;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h3 class="font-semibold" style="color:#F1F5F9;">Log New Activity</h3>
            </div>
        </div>

        <form action="{{ route('activities.store') }}" method="POST" class="px-6 py-6 space-y-6">
            @csrf

            {{-- Type Selector --}}
            <div>
                <label class="frm-label">Activity Type <span style="color:#F87171;">*</span></label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @php
                    $types = [
                        'meeting'   => ['label'=>'Meeting',   'color'=>'#818CF8', 'bg'=>'rgba(129,140,248,0.12)', 'border'=>'rgba(129,140,248,0.4)', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        'call'      => ['label'=>'Call',      'color'=>'#22D3EE', 'bg'=>'rgba(34,211,238,0.12)',  'border'=>'rgba(34,211,238,0.4)',  'icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                        'note'      => ['label'=>'Note',      'color'=>'#FBBF24', 'bg'=>'rgba(251,191,36,0.12)',  'border'=>'rgba(251,191,36,0.4)',  'icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                        'follow_up' => ['label'=>'Follow-up', 'color'=>'#34D399', 'bg'=>'rgba(52,211,153,0.12)',  'border'=>'rgba(52,211,153,0.4)',  'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ];
                    $selectedType = old('type', 'meeting');
                    @endphp
                    @foreach($types as $key => $t)
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="{{ $key }}" class="sr-only"
                               {{ $selectedType === $key ? 'checked' : '' }}
                               onchange="updateTypeCards()">
                        <div id="type-card-{{ $key }}"
                             class="rounded-xl p-3.5 text-center transition-all duration-150 border-2"
                             style="{{ $selectedType === $key
                                 ? 'background-color:'.$t['bg'].'; border-color:'.$t['color'].';'
                                 : 'background-color:#0A1628; border-color:#253548;' }}">
                            <svg class="w-6 h-6 mx-auto mb-1.5" style="color:{{ $t['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $t['icon'] }}"/>
                            </svg>
                            <span class="text-xs font-semibold" style="color:{{ $t['color'] }};">{{ $t['label'] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('type')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="frm-label">Title <span style="color:#F87171;">*</span></label>
                <input type="text" name="title" required value="{{ old('title') }}"
                       class="frm-input"
                       placeholder="e.g. Discovery call with Acme Corp">
                @error('title')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="frm-label">
                    Description / Notes
                    <span class="text-xs font-normal ml-1" style="color:#64748B;">(optional)</span>
                </label>
                <textarea name="description" rows="4" class="frm-textarea" style="resize:vertical;"
                          placeholder="Add any notes, outcomes, or details...">{{ old('description') }}</textarea>
            </div>

            {{-- Date & Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="frm-label">Activity Date & Time <span style="color:#F87171;">*</span></label>
                    <input type="datetime-local" name="activity_date"
                           value="{{ old('activity_date', now()->format('Y-m-d\TH:i')) }}"
                           class="frm-input" style="color-scheme:dark;">
                    @error('activity_date')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="frm-label">Status</label>
                    <select name="status" class="frm-select">
                        <option value="planned"   {{ old('status','planned')==='planned'   ? 'selected':'' }} style="background:#0A1628;">Planned</option>
                        <option value="completed" {{ old('status')==='completed' ? 'selected':'' }} style="background:#0A1628;">Completed</option>
                        <option value="cancelled" {{ old('status')==='cancelled' ? 'selected':'' }} style="background:#0A1628;">Cancelled</option>
                    </select>
                </div>
            </div>

            {{-- Follow-up --}}
            <div>
                <label class="frm-label">
                    Follow-up Date
                    <span class="text-xs font-normal ml-1" style="color:#64748B;">(optional)</span>
                </label>
                <input type="datetime-local" name="follow_up_date"
                       value="{{ old('follow_up_date') }}"
                       class="frm-input" style="color-scheme:dark;"
                       onfocus="this.style.borderColor='#34D399'; this.style.boxShadow='0 0 0 3px rgba(52,211,153,0.12)'"
                       onblur="this.style.borderColor='#253548'; this.style.boxShadow='none'">
                <p class="frm-hint">Set a reminder date to follow up on this activity.</p>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2" style="border-top:1px solid #253548;">
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all"
                        style="background-color:#22D3EE; color:#0F172A;"
                        onmouseover="this.style.backgroundColor='#06B6D4'; this.style.boxShadow='0 4px 14px rgba(34,211,238,0.3)'"
                        onmouseout="this.style.backgroundColor='#22D3EE'; this.style.boxShadow='none'">
                    Log Activity
                </button>
                <a href="{{ route('activities.index') }}"
                   class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                   style="background-color:#253548; color:#CBD5E1; text-decoration:none;"
                   onmouseover="this.style.backgroundColor='#334155'" onmouseout="this.style.backgroundColor='#253548'">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const typeColors = {
    meeting:   { color:'#818CF8', bg:'rgba(129,140,248,0.12)' },
    call:      { color:'#22D3EE', bg:'rgba(34,211,238,0.12)'  },
    note:      { color:'#FBBF24', bg:'rgba(251,191,36,0.12)'  },
    follow_up: { color:'#34D399', bg:'rgba(52,211,153,0.12)'  },
};
function updateTypeCards() {
    const selected = document.querySelector('input[name="type"]:checked')?.value;
    Object.keys(typeColors).forEach(key => {
        const card = document.getElementById('type-card-' + key);
        if (!card) return;
        card.style.backgroundColor = key === selected ? typeColors[key].bg    : '#0A1628';
        card.style.borderColor     = key === selected ? typeColors[key].color : '#253548';
    });
}
document.querySelectorAll('input[name="type"]').forEach(r => r.addEventListener('change', updateTypeCards));
</script>
@endsection
