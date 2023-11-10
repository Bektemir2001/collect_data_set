<script>
    function lineChart(data)
    {
        options = {
            chart: {
                height: 350,
                type: "line",
                zoom: {
                    enabled: !1
                }
            },
            colors: ["#4788ff"],
            series: [{
                name: "Desktops",
                data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
            }],
            dataLabels: {
                enabled: !1
            },
            stroke: {
                curve: "straight"
            },
            title: {
                text: "Product Trends by Month",
                align: "left"
            },
            grid: {
                row: {
                    colors: ["#f3f3f3", "transparent"],
                    opacity: .5
                }
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep"]
            }
        };
        if(typeof ApexCharts !== typeof undefined){
            (chart = new ApexCharts(document.querySelector("#apex-basic"), options)).render()
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
    }
    lineChart(null);
</script>
