/*
    Skript für Ajax-Requests bezgl. Daten für ExpensesChart
    dep: Chart.js, JQuery
*/
(() => {
    const options = document.querySelectorAll('.multiple-choice .option');
    const canvas = document.getElementById('expensesChart');
    const ctx = canvas.getContext('2d');

    let chart;

    console.dir(options);

    const drawChart = (data, ctx = undefined) => {
        if(chart === undefined) {

            chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        'Gas Station',
                        'Tickets',
                        'Other'
                        ],
                    datasets: [{
                        label: 'All Expenses',
                        data: [
                            data.fuel,
                            data.ticket,
                            data.other
                        ],
                        borderWidth: 0,
                        backgroundColor: [
                            'hsl(240, 30%, 35%)',
                            'hsla(355, 80%, 58%, 1)',
                            'hsl(40, 80%, 70%)'
                        ]
                    }]
                },
                options: {
                    cutoutPercentage: 50,
                    legend: {
                        display: false,
                        position: 'bottom'
                    },
                    tooltips: {
                        enabled: true,
                        cornerRadius: 2,
                    }
                }
            });

        } else {

            chart.data.datasets[0].data = [data.fuel, data.ticket, data.other];
            chart.update();

        }
    }

    const getData = (id, scope) => {
        let url = "/expenses/" + id + "/getData";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'get',
            data: {
                'scope': scope,
            },  
            success: function(res){

                let data = {
                    'fuel': res.fuel_sum,
                    'ticket': res.ticket_sum,
                    'other': res.other_sum
                };

                drawChart(data, ctx);
            }
         });
    }

    const scopeClicked = (event) => {

        let value = parseInt(event.target.dataset.value);

        switch(value) {

            // All Time
            case 1:
                getData(1, 'all');
                break;

            // This Week
            case 2:
                getData(1, 'week');
                break;

            // This Year
            case 3:
                getData(1, 'year');
                break;

            // Error Handling
            default:
        }
    }

    getData(1, 'all');

    for(let i = 0; i < options.length; i++) {
        options[i].onclick = scopeClicked;
    }

})();