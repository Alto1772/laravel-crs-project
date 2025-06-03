<div class="card">
    <div class="card-body">
        <div x-data="barChart" class="w-full" x-init="build({{ Js::from($this->correct_answers_count) }})"></div>
    </div>
</div>

@assets
    @vite(['resources/js/vendor/apexcharts.js', 'resources/css/vendor/apexcharts.css'])
@endassets

@script
    <script>
        Alpine.data('barChart', () => ({
            'chart': null,
            build(answersCount) {
                this.chart = new ApexCharts(this.$el, {
                    chart: {
                        type: "bar",
                        height: 400,
                        toolbar: {
                            show: false,
                        },
                        zoom: {
                            enabled: false,
                        }
                    },

                    title: {
                        text: "Correct answers each Board Program",
                        margin: 20,
                        style: {
                            color: "oklch(var(--bc))",
                            fontSize: "20px",
                            fontWeight: 700,
                        },
                    },
                    series: [{
                        name: "# of correct answers",
                        data: Object.values(answersCount),
                    }],
                    plotOptions: {
                        bar: {
                            distributed: true,
                            horizontal: false,
                            columnWidth: "30px",
                        },
                    },
                    legend: {
                        show: false,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    colors: [
                        "oklch(var(--p))",
                        "oklch(var(--in))",
                        "oklch(var(--er))",
                        "oklch(var(--a))",
                        "oklch(var(--wa))",
                        "oklch(var(--su))",
                        "oklch(var(--n))",
                        "oklch(var(--wa))",
                        "oklch(var(--er))",
                        "oklch(var(--a))",
                        "oklch(var(--n))",
                        "oklch(var(--p))",
                        "oklch(var(--su))",
                        "oklch(var(--in))",
                    ],
                    xaxis: {
                        type: "category",
                        categories: Object.keys(answersCount),
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                        labels: {
                            style: {
                                colors: "oklch(var(--bc) / 0.9)",
                                fontSize: "12px",
                                fontWeight: 400,
                            },
                        },
                    },
                    yaxis: {
                        labels: {
                            align: "left",
                            minWidth: 0,
                            maxWidth: 140,
                            style: {
                                colors: "oklch(var(--bc) / 0.9)",
                                fontSize: "12px",
                                fontWeight: 400,
                            },
                        },
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "darken",
                                value: 0.9,
                            },
                        },
                    },
                    responsive: [{
                        breakpoint: 568,
                        options: {
                            chart: {
                                height: 200,
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: "70%",
                                },
                            },
                            dataLabels: {
                                style: {
                                    fontSize: "12px",
                                },
                            },
                            title: {
                                style: {
                                    fontSize: "16px",
                                },
                            },
                        },
                    }],
                })
                $nextTick(() => this.chart.render())
            }
        }))
    </script>
@endscript
