<div class="card">
    <div class="card-body">
        <div x-data="pieChart" class="w-full" x-init="build({{ Js::from($this->answers_count) }})"></div>
    </div>
</div>

@assets
    @vite(['resources/js/vendor/apexcharts.js', 'resources/css/vendor/apexcharts.css'])
@endassets

@script
    <script>
        Alpine.data('pieChart', () => ({
            'chart': null,
            build(answersCount) {
                this.chart = new ApexCharts(this.$el, {
                    chart: {
                        height: 400,
                        type: "pie",
                        zoom: {
                            enabled: false,
                        },
                    },
                    series: Object.values(answersCount),
                    labels: Object.keys(answersCount),
                    title: {
                        show: false,
                        margin: 20,
                        style: {
                            color: "oklch(var(--bc))",
                            fontSize: "20px",
                            fontWeight: 700,
                        },
                    },
                    colors: [
                        "oklch(var(--p))",
                        "oklch(var(--n))",
                        "oklch(var(--a))",
                        "oklch(var(--in))",
                        "oklch(var(--wa))",
                        "oklch(var(--su))",
                        "oklch(var(--er))",
                    ],
                    dataLabels: {
                        style: {
                            fontSize: "12px",
                            fontWeight: "500",
                            colors: [
                                "oklch(var(--pc))",
                                "oklch(var(--nc))",
                                "oklch(var(--ac))",
                                "oklch(var(--inc))",
                                "oklch(var(--wac))",
                                "oklch(var(--suc))",
                                "oklch(var(--erc))",
                            ],
                        },
                        dropShadow: {
                            enabled: false,
                        },
                        formatter: (value) => `${value.toFixed(1)} %`,
                    },
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                offset: -15,
                            },
                        },
                    },
                    legend: {
                        show: true,
                        position: "bottom",
                        markers: {
                            offsetX: -2
                        },
                        labels: {
                            useSeriesColors: true,
                        },
                    },
                    stroke: {
                        show: false,
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "none",
                            },
                        },
                    },
                    responsive: [{
                        breakpoint: 568,
                        options: {
                            chart: {
                                height: 300,
                            },
                        },
                    }, ],
                })
                $nextTick(() => this.chart.render())
            }
        }))
    </script>
@endscript
