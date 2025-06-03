<div class="rounded-md bg-base-100 shadow" id="college-datatable">
    @session('success')
        <div class="mb-2 p-2.5">
            <x-alert class="alert-success">{{ $value }}</x-alert>
        </div>
    @endsession

    <div class="flex items-center gap-3 border-b border-base-content/25 px-5 py-3">
        <x-datatable.search wire:model.live.debounce.300ms="search" />

        <div class="flex flex-1 items-center justify-end gap-3">
            <a href="{{ route('admin.colleges.create') }}" class="dropdown-toggle btn btn-soft btn-sm max-sm:btn-square"
                wire:navigate>
                <span class="flex items-center gap-2">
                    <span class="icon-[tabler--plus] size-4"></span>
                    <span class="max-sm:hidden">Add College</span>
                </span>
            </a>
        </div>
    </div>
    <div class="horizontal-scrollbar overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="relative overflow-hidden">
                <x-loading-overlay liveLoading />
                <table class="table min-w-full">
                    <thead>
                        <tr>
                            <x-datatable.sortable-header wire:click="sortBy('name')" :sortField="$sortField" field="name"
                                :sortDirection="$sortDirection">
                                Name
                            </x-datatable.sortable-header>

                            <x-datatable.sortable-header wire:click="sortBy('long_name')" :sortField="$sortField"
                                field="long_name" :sortDirection="$sortDirection">
                                Long Name
                            </x-datatable.sortable-header>

                            <x-datatable.sortable-header wire:click="sortBy('num_programs')" :sortField="$sortField"
                                field="num_programs" :sortDirection="$sortDirection">
                                # of Board Progs.
                            </x-datatable.sortable-header>

                            <th scope="col">Image</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($colleges as $college)
                            <tr wire:key="{{ $college->id }}">
                                <td>{{ $college->name }}</td>
                                <td>
                                    {{ Str::limit($college->long_name, 32) }}
                                </td>
                                <td>{{ $college->num_programs }}</td>
                                <td>
                                    <img src="{{ asset($college->image) }}" alt="College Image"
                                        class="h-10 w-10 rounded-md object-cover" />
                                </td>
                                <td>
                                    <a href="{{ route('admin.colleges.edit', $college) }}"
                                        class="btn btn-circle btn-text btn-sm" aria-label="Edit button" wire:navigate>
                                        <span class="icon-[tabler--pencil] size-5"></span>
                                    </a>
                                    <button class="btn btn-circle btn-text btn-sm" aria-label="Delete button"
                                        wire:confirm="Are you sure you want to delete this college entry?"
                                        wire:click="deleteRecord({{ $college->id }})">
                                        <span class="icon-[tabler--trash] size-5"></span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 text-center text-base-content/60">
                                    No college entries found...
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-datatable.pagination :data="$colleges" />
</div>
