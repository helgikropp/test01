export class TstReport {
    constructor() {
      document.querySelectorAll('template#js').forEach(tpl => {
        const charts = JSON.parse(atob(tpl.content.textContent));
        tpl.remove();
        
        const ctx = document.getElementById('chart');
        const data = {
            labels: charts.labels,
            datasets: []
        };

        charts.items.forEach(chart => {
          data.datasets.push({
            label: chart.action,
            data: chart.data,
            borderWidth: 1
          });
        });

        new Chart(ctx, {
          type: 'bar',
          data,
          options: {
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Dates'
                }
              },
              y: {
                title: {
                  display: true,
                  text: 'Count'
                },
                beginAtZero: true,
                ticks: {
                  stepSize: 1
                }
              }
            }
          }
        });
      });                
    }
}