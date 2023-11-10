<script>
    function pieChart(data)
    {
        options = {
            chart: {
                width: 380,
                type: "pie"
            },
            labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
            series: [44, 55, 13, 43, 22],
            colors: ["#4788ff", "#ff4b4b", "#876cfe", "#37e6b0", "#c8c8c8"],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: "bottom"
                    }
                }
            }]
        };
        (chart = new ApexCharts(document.querySelector("#apex-pie-chart"), options)).render()
        const body = document.querySelector('body')
        if (body.classList.contains('dark')) {
            apexChartUpdate(chart, {
                dark: true
            })
        }

        document.addEventListener('ChangeColorMode', function (e) {
            apexChartUpdate(chart, e.detail)
        })
    }
    pieChart(null);
</script>
