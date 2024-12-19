'use strict'

function getCovid() {
    try {
        let page = 1;
        let Nbpage = 50;
        fetch(`https://tabular-api.data.gouv.fr/api/resources/2963ccb5-344d-4978-bdd3-08aaf9efe514/data/?page=${page}&page_size=${Nbpage}`)
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const maxevilleData = data.data.map(item => ({
                semaine: item.semaine,
                MAXEVILLE: item.MAXEVILLE
            }));

            const ctx = document.getElementById('covidChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: maxevilleData.map(item => item.semaine),
                    datasets: [{
                        label: 'Maxeville COVID Data',
                        data: maxevilleData.map(item => item.MAXEVILLE),
                        borderColor: 'rgb(255, 203, 49)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });       
    } catch (error) {
        console.error(error);
    }
}

export { getCovid };