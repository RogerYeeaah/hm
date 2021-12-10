var ctx = document.getElementById("polarChart").getContext("2d");
var myChart = new Chart(ctx, {
	type: 'polarArea',
	data: {
		labels: ["創造力", "洞察力", "正直", "社交智慧", "領導力", "幽默", "樂觀", "活力", "勇敢", "善良"],
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
				"#d4a5b3",
				"#90a4ca"
			],
			data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
			borderWidth: 1,
			borderColor: '#d3e0e2'
		}]
	},
	options: {
		animation: {
			animateRotate: false,
			animateScale: true
		},
		plugins: {
			legend: {
				display: false,
			}
		},
		layout: {
			padding: 50,
		},
		scales: {
			r: {
				angleLines: {
					display: true,
					center: true,
					  color: '#d3e0e2'
				},
				ticks: {
					max: 15,
					min: 0,
					display: false
				},
				grid: {
					color: '#d3e0e2'
				}
			}
		}
	}
});