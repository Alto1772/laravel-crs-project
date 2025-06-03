<div {{ $attributes }} x-data="{
    name: '',
    long_name: '',
    id: null,
    editIndex: null,

    resetTexts() {
        this.name = ''
        this.long_name = ''
        this.id = null
        this.editIndex = null
    },

    addOrEdit() {
        if (!this.name || !this.long_name) {
            alert('Both Name and Full Name are required!')
            return
        }

        data = {
            id: this.id,
            name: this.name,
            long_name: this.long_name,
            edited: true,
        }

        if (this.editIndex !== null) {
            $wire.programs[this.editIndex] = data
        } else {
            $wire.programs.push(data)
        }

        this.resetTexts()
    },

    editEntry(index) {
        this.id = $wire.programs[index].id
        this.name = $wire.programs[index].name
        this.long_name = $wire.programs[index].long_name
        this.editIndex = index
    },

    cancelEdit() {
        this.resetTexts()
    },

    toggleEdit(index) {
        if (this.editIndex === index) this.cancelEdit()
        else this.editEntry(index)
    },

    deleteEntry(index) {
        if (
            confirm(
                `Are you sure you want to delete ${$wire.programs[index].name}?`,
            )
        ) {
            $wire.programs.splice(index, 1)
        }
    },
}">
    <h3 class="mb-4 text-lg font-semibold">Programs</h3>
    <div class="mb-4 flex items-center gap-3">
        <x-text-input class="basis-3/12" variant="floating" name="program_name" id="program_name" x-model="name"
            label="Abbrev." maxlength="8" {{-- @keyup.enter.prevent="addOrEdit" --}} />
        <x-text-input class="basis-9/12" variant="floating" name="program_long_name" id="program_long_name"
            x-model="long_name" label="Full Name" {{-- @keyup.enter.prevent="addOrEdit" --}} />
        <button type="button" id="add-program-btn" class="btn btn-primary btn-sm h-10" @click="addOrEdit">
            <span class="size-5"
                :class="editIndex === null ? 'icon-[tabler--plus]' : 'icon-[tabler--pencil-check]'"></span>
        </button>
    </div>

    <div class="horizontal-scrollbar overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden">
                <table class="table min-w-full" id="programs-table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Long Name</th>
                            <th scope="col" class="w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(program, i) in $wire.programs">
                            <tr x-bind:class="program.edited && 'bg-warning/5'">
                                <td x-text="program.name"></td>
                                <td x-text="program.long_name"></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button type="button" class="btn btn-square btn-soft btn-sm"
                                            x-bind:class="editIndex === i ? 'btn-warning' : 'btn-primary'"
                                            x-on:click="toggleEdit(i)">
                                            <span class="size-4"
                                                x-bind:class="editIndex === i ? 'icon-[tabler--pencil-x]' : 'icon-[tabler--edit]'"></span>
                                        </button>
                                        <button type="button" class="btn btn-square btn-error btn-soft btn-sm"
                                            x-on:click="deleteEntry(i)">
                                            <span class="icon-[tabler--trash] size-4"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @error('programs*')
        <div class="mt-4 text-center text-sm text-error">
            {{ $message }}
        </div>
    @enderror
</div>
