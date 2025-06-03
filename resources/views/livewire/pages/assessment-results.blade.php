<x-main-container class="flex justify-center items-center">
    <div class="max-w-xl space-y-6 text-center">
        <div class="card">
            <div class="card-body">
                <div x-data="barChart" class="w-full" x-init="build({{ Js::from($recChart->keys()) }}, {{ Js::from($recChart->values()) }})"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-left">
                <h3 class="text-xl font-semibold mb-3">Congratulations <span
                        class="font-bold underline">{{ $fullName ?? '<No Name>' }}</span>!</h3>
                <p class="text-base-content/70 mb-3">You have
                    successfully
                    finished
                    answering the assessment. Here are the top three recommended board programs for you:
                </p>
                <ol class="text-md list-decimal list-inside ms-2">
                    @foreach ($recommendations as $boardProgram => $percentage)
                        @if ($loop->index >= 3 && !$expand)
                            @break
                        @endif
                        <li @class(['font-bold ' => $loop->first])>{{ $boardProgram }}</li>
                    @endforeach
                </ol>
                <p class="ms-2">
                    @if (count($recommendations) > 3 && !$expand)
                        <button type="button" wire:click="$set('expand', true)" class="link link-primary">See
                            more...</button>
                    @endif
                </p>
            </div>
        </div>
        <div class="flex gap-2 justify-between">
            <x-tooltip message="Retake assessment">
                <a href="{{ route('questionnaire.take') }}" class="btn btn-soft btn-secondary btn-square">
                    <span class="icon-[tabler--reload] size-5"></span>
                </a>
            </x-tooltip>
            <a href="{{ route('colleges') }}" class="btn btn-primary">Return to College Overview</a>
        </div>
    </div>
</x-main-container>

@script
    <script>
        // Refresh on page update
        Livewire.hook('morph.added', ({
            el,
            component
        }) => {
            window.HSStaticMethods.autoInit([
                'tooltip',
            ]);
        });
    </script>
@endscript


@assets
    @vite(['resources/js/vendor/apexcharts.js', 'resources/css/vendor/apexcharts.css'])
    {{-- @vite('resources/js/vendor/lodash.js') --}}
@endassets

@script
    <script>
        Alpine.data('barChart', () => ({
            'chart': null,
            build(categories, data) {
                this.chart = new ApexCharts(this.$el, {
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    series: [{
                        name: '',
                        data,
                    }],
                    plotOptions: {
                        bar: {
                            distributed: true,
                            horizontal: false,
                            columnWidth: '30px'
                        }
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: [
                        'oklch(var(--p))',
                        'oklch(var(--n))',
                        'oklch(var(--a))',
                        'oklch(var(--in))',
                        'oklch(var(--wa))',
                        'oklch(var(--su))',
                        'oklch(var(--er))',
                    ],
                    xaxis: {
                        categories,
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: 'oklch(var(--bc) / 0.9)',
                                fontSize: '12px',
                                fontWeight: 400
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        labels: {
                            align: 'left',
                            minWidth: 0,
                            maxWidth: 140,
                            style: {
                                colors: 'oklch(var(--bc) / 0.9)',
                                fontSize: '12px',
                                fontWeight: 400
                            },
                            formatter: value => `${value}%`
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'darken',
                                value: 0.9
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: value => `${value}%`
                        },
                    },
                })
                $nextTick(() => this.chart.render())
            },
        }))
    </script>
@endscript
