fetch(totalStudentsDataUrl)
    .then((response) => response.json())
    .then((data) => {
        // Create labels like "2025/2026 - 1st Semester"
        const labels = data.map(
            (item) => `${item.school_year} - ${item.semester}`
        );
        const activeCounts = data.map((item) => item.count);

        var ctx = document.getElementById("myAreaChartStudents");
        var myAreaChartStudents = new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
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
                        data: activeCounts,
                    },
                ],
            },
            options: {
                scales: {
                    xAxes: [
                        {
                            gridLines: { display: false },
                            ticks: { autoSkip: false }, // show all semester labels
                        },
                    ],
                    yAxes: [
                        {
                            ticks: {
                                min: 0,
                                max: Math.max(...activeCounts) + 5,
                                maxTicksLimit: 5,
                            },
                            gridLines: { color: "rgba(0, 0, 0, .125)" },
                        },
                    ],
                },
                legend: { display: true },
            },
        });
    })
    .catch((error) =>
        console.error("Error fetching active students data:", error)
    );
