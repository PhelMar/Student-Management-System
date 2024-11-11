fetch(violationsBarDataUrl)
  .then(response => response.json())
  .then(data => {
    // Ensure data is not empty and properly formatted
    const months = data.map(item => {
      // Check if month is numeric (e.g., 1 for January)
      if (typeof item.month === 'number') {
        return new Date(0, item.month - 1).toLocaleString('default', { month: 'long' });
      }
      return item.month || 'Unknown'; // Fallback to 'Unknown' if month is invalid
    });
    
    const violations = data.map(item => item.violations || 0); // Default to 0 if violations is undefined

    // Render the bar chart with violations data
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: months,  // Ensure months are correctly displayed
        datasets: [{
          label: "Violations",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          data: violations,
        }],
      },
      options: {
        scales: {
          x: {
            grid: {
              display: false
            },
            ticks: {
              maxTicksLimit: 6
            }
          },
          y: {
            ticks: {
              min: 0,
              maxTicksLimit: 5
            },
            grid: {
              display: true
            }
          }
        },
        legend: {
          display: false
        }
      }
    });
  })
  .catch(error => {
    console.error('Error fetching violations data:', error);
  });