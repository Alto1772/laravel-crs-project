<div class="space-y-4 *:text-center max-w-3xl mx-auto">
    <x-loading-overlay :inMainContainer="true" message="Generating detailed analysis charts. Please wait..." :liveLoading="true"
        hidden />
    <section class="flex">
        <h1 class="flex-1 text-2xl font-bold">Summary</h1>
        <x-dropdown>
            <x-slot name="toggle">
                <x-tooltip class="[--placement:bottom]" message="Actions">
                    <x-dropdown.button class="btn-text btn-secondary btn-square" :noIcon="true">
                        <span class="icon-[tabler--dots-vertical]"></span>
                    </x-dropdown.button>
                </x-tooltip>
            </x-slot>

            <li><button class="dropdown-item" wire:click='retrain'>
                    <span class="icon-[tabler--refresh] size-5 shrink-0"></span>
                    Retrain</button></li>
            <li><button class="dropdown-item" wire:click='reanalyze'>
                    <span class="icon-[tabler--report-analytics] size-5 shrink-0"></span>
                    Reanalyze</button></li>
        </x-dropdown>
    </section>
    <section class="stats grid">
        <div class="stat">
            <div class="stat-title">Board Programs</div>
            <div class="stat-value">{{ $this->analysis['classes'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Data Points</div>
            <div class="stat-value">{{ $this->analysis['data_points'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Questions</div>
            <div class="stat-value">{{ $this->analysis['features'] }}</div>
        </div>
    </section>
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Cluster Visualization</h1>
        </div>
        <div class="card-body">
            <img src="{{ asset($this->analysis['cluster_visualization']) }}" alt="Cluster Graph" class="w-full h-max">
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Class Distribution</h3>
        </div>
        <div class="card-body">
            <img src="{{ asset($this->analysis['class_distribution']) }}" alt="Class Distribution Graph"
                class="w-full h-max">
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h1 class="text-2xl font-bold">Confusion Matrix</h1>
        </div>
        <div class="card-body">
            @empty($this->confusion_matrix)
                <p class="text-base-content/60 italic text-sm">Graph not generated due to training data being not
                    available...</p>
            @else
                <img src="{{ asset($this->confusion_matrix) }}" alt="Confusion Matrix Graph" class="w-full h-max">
            @endempty
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h1 class="text-2xl font-bold">Classification Report</h1>
        </div>
        <div class="card-body overflow-x-scroll">
            @empty($this->classification_report)
                <p class="text-base-content/60 italic text-sm">Graph not generated due to training data being not
                    available...</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th class="min-w-full"></th>
                            <th>F1-Score</th>
                            <th>Precision</th>
                            <th>Recall</th>
                            <th>Support</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->classification_report->filter(fn($v, $k) => is_integer($k)) as $programId => $entries)
                            <tr>
                                <td>{{ $this->board_programs->find($programId)->name }}</td>
                                <td>{{ $this->format_percent($entries['f1-score']) }}</td>
                                <td>{{ $this->format_percent($entries['precision']) }}</td>
                                <td>{{ $this->format_percent($entries['recall']) }}</td>
                                <td>{{ $entries['support'] }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td></td>
                        </tr> <!-- SPLIT -->

                        @foreach ($this->classification_report->filter(fn($v, $k) => !is_integer($k)) as $key => $entries)
                            <tr class="bg-info/10">
                                <td>{{ Str::title($key) }}</td>

                                @if ($key === 'accuracy')
                                    <td colspan="2"></td>
                                    <td>{{ $this->format_percent($entries[0]) }}</td>
                                    <td></td>
                                @else
                                    <td>{{ $this->format_percent($entries['f1-score']) }}</td>
                                    <td>{{ $this->format_percent($entries['precision']) }}</td>
                                    <td>{{ $this->format_percent($entries['recall']) }}</td>
                                    <td>{{ $entries['support'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endempty
        </div>
    </div>
    {{-- <div class="card">
        <div class="card-header">
            <h1 class="text-2xl font-bold">Feature Importance</h1>
        </div>
        <div class="card-body">
            <img src="{{ asset($this->analysis['feature_importance']) }}" alt="Feature Importance Graph"
                class="w-full h-max">
        </div>
    </div> --}}
</div>


@script
    <script>
        // Refresh on page update
        Livewire.hook('morph.added', ({
            el,
            component
        }) => {
            window.HSStaticMethods.autoInit([
                'dropdown',
            ]);
        });
    </script>
@endscript
