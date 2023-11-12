<script>
    let colors = ["#4788ff", "#ff4b4b", "#876cfe", "#37e6b0", "#c8c8c8", "#B237E6FF",
        "#C2C096", "#4D4A15", "#84F0C2", "#A2C8B7", "#05331E", "#D66CB9", "#AD91A5",
        "#973D4A", "#080808", "#ECC70E", "#80EC0E"]

    function getData()
    {
        let url = "{{route('admin.profile.diagram')}}";
        fetch(url, {
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        })
            .then(response => response.json())
            .then(data => {
                pieChart(data.data);
            });
    }

    function pieChart(data)
    {
        let labels = [];
        let series = [];
        let pie_colors = [];

        if(data)
        {
            for(let i = 0; i < data.length; i++)
            {
                labels.push(data[i].name);
                if(data[i].context_count > 5000)
                {
                    series.push(300);
                }
                else{
                    series.push(data[i].context_count);
                }

                pie_colors.push(colors[i]);
            }
        }
        else{
            console.log('error')
            return;
        }
        options = {
            chart: {
                width: 380,
                type: "pie"
            },
            labels: labels,
            series: series,
            colors: pie_colors,
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

    getData();
</script>
