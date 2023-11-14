<script>
    let day = 0;
    function previous_Day()
    {
        day = day + 1;
        document.getElementById('apex-basic').innerHTML = '';
        getLineData(day);

    }

    function next_Day()
    {
        if(day > 0)
        {
            day = day - 1;
            document.getElementById('apex-basic').innerHTML = '';
            getLineData(day);
        }

    }

    function getLineData(day)
    {
        data = new FormData();
        data.append('day', day);
        let url = "{{route('admin.profile.graphic')}}";
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            body: data
        })
            .then(response => response.json())
            .then(data => {
                lineChart(data.data);
            });
    }
    function lineChart(data)
    {
        let days = [];
        let context_counts = [];
        if(data)
        {
            for(let i = 0; i < data.length; i++)
            {
                days.push(data[i].day);
                context_counts.push(data[i].context_count);
            }
        }
        else{
            console.log('error')
            return;
        }
        options = {
            chart: {
                height: 350,
                type: "area",
                zoom: {
                    enabled: !1
                }
            },
            colors: ["#4788ff"],
            series: [{
                name: "Contexts",
                data: context_counts
            }],
            dataLabels: {
                enabled: !1
            },
            stroke: {
                curve: "smooth"
            },
            title: {
                text: "Context count for 9 day",
                align: "left"
            },
            grid: {
                row: {
                    colors: ["#f3f3f3", "transparent"],
                    opacity: .5
                }
            },
            xaxis: {
                categories: days
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


    getLineData(0);
</script>
