
fetch(totalStudentsDataUrl)
  .then(response => response.json())
  .then(data => {

    const labels = data.map(item => item.date);
    const activeStudentsCount = data.map(item => item.count);

    var ctx = document.getElementById("myAreaChartStudents");
    var myAreaChartStudents = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: "Active Students",
          lineTension: 0.3,
          backgroundColor: "rgba(40,167,69,0.2)",
          borderColor: "rgba(40,167,69,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(40,167,69,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(40,167,69,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: activeStudentsCount,
        }]
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: Math.max(...activeStudentsCount) + 5, // Adjust max based on data
              maxTicksLimit: 5
            },
            gridLines: {
              color: "rgba(0, 0, 0, .125)",
            }
          }],
        },
        legend: {
          display: true
        }
      }
    });
  })
  .catch(error => console.error("Error fetching active students data:", error));
