@props(['type' => 'primary', 'message'])

<div class="alert alert-{{ $type ?? 'primary' }}" role="alert">
    {{ $message }}
</div>                                                          