<x-layouts.app title="Edit staff account">
    @include('staff._form', ['action' => route('staff.update', $staff), 'staff' => $staff])
</x-layouts.app>
