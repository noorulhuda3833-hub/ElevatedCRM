@extends('layouts.dashboard')
@section('title', 'Edit Task')
@section('header', 'Edit Task')

@section('content')
<style>
.frm-input, .frm-select {
    width:100%; padding:0.7rem 1rem; border-radius:0.5rem; font-size:0.875rem;
    background-color:#0A1628; border:1.5px solid #253548; color:#F1F5F9;
    outline:none; transition:border-color 0.2s, box-shadow 0.2s;
    -webkit-text-fill-color:#F1F5F9; font-family:inherit;
}
.frm-input::placeholder { color:#64748B; }
.frm-input:focus, .frm-select:focus { border-color:#22D3EE; box-shadow:0 0 0 3px rgba(34,211,238,0.12); }
.frm-input:-webkit-autofill, .frm-input:-webkit-autofill:focus {
    -webkit-box-shadow:0 0 0 1000px #0A1628 inset; -webkit-text-fill-color:#F1F5F9;
}
.frm-label { display:block; font-size:0.8125rem; font-weight:500; margin-bottom:0.5rem; color:#CBD5E1; }
</style>

<div class="max-w-xl mx-auto">
    <div class="rounded-2xl overflow-hidden" style="background:linear-gradient(145deg,#1A2A3F,#152030); border:1px solid #253548; box-shadow:0 8px 32px rgba(0,0,0,0.4);">

        <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #253548; background:rgba(0,0,0,0.2);">
            <a href="{{ route('tasks.index') }}"
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h3 class="font-semibold" style="color:#F1F5F9;">Edit Task</h3>
            </div>
        </div>

        <form action="{{ route('tasks.update', $task) }}" method="POST" class="px-6 py-6 space-y-5">
            @csrf @method('PUT')

            <!-- Title -->
            <div>
                <label class="frm-label">Task Title <span style="color:#F87171;">*</span></label>
                <input type="text" name="title" required value="{{ old('title', $task->title) }}"
                       class="frm-input" placeholder="Enter task title">
                @error('title')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
            </div>

            <!-- Deadline -->
            <div>
                <label class="frm-label">
                    Deadline
                    <span class="text-xs font-normal ml-1" style="color:#64748B;">(optional)</span>
                </label>
                <input type="date" name="deadline"
                       value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}"
                       class="frm-input" style="color-scheme:dark;">
            </div>

            <!-- Status -->
            <div>
                <label class="frm-label">Status</label>
                <select name="status" class="frm-select">
                    <option value="pending"   {{ old('status',$task->status)==='pending'   ? 'selected':'' }} style="background:#0A1628;">Pending</option>
                    <option value="completed" {{ old('status',$task->status)==='completed' ? 'selected':'' }} style="background:#0A1628;">Completed</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2" style="border-top:1px solid #253548;">
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all"
                        style="background-color:#22D3EE; color:#0F172A;"
                        onmouseover="this.style.backgroundColor='#06B6D4'; this.style.boxShadow='0 4px 14px rgba(34,211,238,0.3)'"
                        onmouseout="this.style.backgroundColor='#22D3EE'; this.style.boxShadow='none'">
                    Save Changes
                </button>
                <a href="{{ route('tasks.index') }}"
                   class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                   style="background-color:#253548; color:#CBD5E1; text-decoration:none;"
                   onmouseover="this.style.backgroundColor='#334155'" onmouseout="this.style.backgroundColor='#253548'">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
