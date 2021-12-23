var ctx = document.getElementById("polarChart").getContext("2d");
var myChart = new Chart(ctx, {
	type: 'polarArea',
	data: {
		labels: ["創造力", "洞察力", "正直", "社交智慧", "領導力", "幽默", "樂觀", "活力"],
		datasets: [{
			backgroundColor: [
				"#befada",
				"#adcde4",
				"#b5cbcd",
				"#e8d0eb",
				"#f1e09b",
				"#e7c2b4",
				"#a4afc3",
				"#a78197",
			],
			data: [1, 2, 3, 4, 5, 6, 7, 8],
			borderWidth: 1,
			borderColor: '#ffffff'
		}]
	},
  options: {
    layout: {
      padding: 1
    },
		animation: {
			animateRotate: false,
			animateScale: true
		},
		plugins: {
			legend: {
				display: false,
			}
		},
		scales: {
			r: {
        min: 0,
        max: 10,
				angleLines: {
          max: 10,
					display: true,
					center: true,
          color: '#ffffff'
				},
        ticks: {
          display: false,
          stepSize: 1
        },
				grid: {
					color: '#ffffff'
				}
			}
		}
	}
});