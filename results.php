<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="fb:app_id" content="334437811929428">
    <meta name="og:url" content="http://uat.erduo.tw/wellness_wheel/results.php">
    <meta name="og:image" content="http://uat.erduo.tw/wellness_wheel/resultimg/<?php echo $_GET['img']; ?>.png">
    <meta name="og:description" content="The ness Wellness Wheel is a great way to view your life from a bird's eye perspective and identify where you are at this moment in time while also discovering where you want it to be.">
    <meta name="og:title" content="nesswellnesswheel">
    <meta name="og:site_name" content="nesswellnesswheel">
    <meta name="og:type" content="website">
    <link rel="icon" href="img/icons/favicon.ico">
    <title>NesswellnessWheel</title>
    <script src="./scripts/v3.2.8/vue.global.prod.js" type="text/javascript" charset="utf-8"></script>
    <script src="./scripts/jquery/jquery.min.js"></script>
    <script src="./scripts/chart/chart.min.js"></script>
    <script src="./scripts/chart/chartjs-plugin-datalabels.js"></script>
    <script src="./scripts/data.js"></script>
    <script src="./scripts/mathjs/math.min.js"></script>
    <script src="./scripts/html2canvas/html2canvas.min.js"></script>
    <link rel="stylesheet" href="./styles/reset.css">
    <link rel="stylesheet" href="./styles/custom.css">
  </head>
  <body class="result">
    <div class="header" id="header">
      <div class="container">
	  	<a class="logo-box" href="https://www.nesswellness.com/">
          <div class="logo" style="background-image: url(./img/logo.png)"></div>
		</a>
        <div class="function-box"><a href="javascript:;" @click="lenChange()"><img src="./img/icons/globe.png" alt="">{{ len }}</a></div>
        <div class="hamburger" :class="active === false? '':'open'" @click="active = !active"><span></span>
          <transition name="slide">
            <ul class="menu" v-if="active">
              <li><a href="#anchor-about">{{ menu[0] }}</a></li>
              <li><a href="#anchor-resources">{{ menu[1] }}</a></li>
              <li><a href="form.html">{{ menu[2] }}</a></li>
            </ul>
          </transition>
        </div>
      </div>
      <script>
        (function(d, s, id) {
        	var js, fjs = d.getElementsByTagName(s)[0];
        	if (d.getElementById(id)) return;
        	js = d.createElement(s); js.id = id;
        	js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        	fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        
        
        window.fbAsyncInit = function() {
        	FB.init({
        		appId      : '334437811929428',
        		xfbml      : true,
        		version    : 'v12.0'
        	});
        };
        
        const header = Vue.createApp({
        	data() {
        		return {
        			menu:[],
        			active: false,
        			len: localStorage.len
        		}
        	},
        	created: function() {
        		this.onHeaderCatch();
        		this.onLenCatch();
        	},
        	mounted: function() {
        	},
        	methods: {
        		onHeaderCatch: function() {
        			if(this.len === 'en') {
        				this.menu = pageData.en.menu;
        			} else if(this.len === '中') {
        				this.menu = pageData.ch.menu;
        			} else {
        				this.menu = pageData.en.menu;
        			}
        		},
        		onLenCatch: function() {
        			if(this.len != 'en' && this.len != '中') {
        				localStorage.setItem('len', 'en')
        				this.len = localStorage.len;
        			}
        		},
        		lenChange: function() {
        			if(localStorage.len === 'en') {
        				localStorage.setItem('len', '中')
        				this.len = localStorage.len;
        				this.menu = pageData.ch.menu;
        			} else if (localStorage.len === '中') {
        				localStorage.setItem('len', 'en')
        				this.len = localStorage.len;
        				this.menu = pageData.en.menu;
        			} else {
        				localStorage.setItem('len', 'en')
        				this.len = localStorage.len;
        				this.menu = pageData.en.menu;
        			}
        			location. reload();
        		}
        	},
        	watch: {
        		active: function (newActive, oldActive) {
        			if (newActive == true) {
        				window.document.querySelector('body').style['overflow'] = 'hidden';
        			} else {
        				window.document.querySelector('body').style['overflow'] = '';
        			}
        		}
        	}
        });
        
        header.mount('#header');
      </script>
    </div>
    <div class="results" id="app">
      <div class="container">
        <p class="name" v-if="this.len === 'en'">{{ 'Hi ' + name }},</p>
        <p class="name" v-if="this.len === '中'">{{ '嗨 ' + name }},</p>
        <div class="title">{{ results.title }}</div>
        <div class="result-canvas">
          <canvas id="polarChart"></canvas>
        </div>
        <div class="function">
          <label class="switch" for="checkbox">
            <input type="checkbox" id="checkbox" v-model="check" @click="chartSwitch(check)"><span class="slider round"></span>
          </label><a class="fbshare" href="javascript:void(0);" onclick="saveImg()"><img src="./img/icons/facebook-w.png"></a><a class="download" href="javascript:void(0)" @click="downloadImg()"><img src="./img/icons/download-w.png"></a>
        </div>
        <p class="ps">{{ results.ps }}</p>
        <div class="card highest" v-for="(items, index) in this.maxIndex" key="index">
          <div class="img" :style="'background-image: url(./img/icons/' + items + '.png)'"></div><span>You scored highest on {{ items }} health</span>
        </div><span class="stairs" style="background-image: url(./img/stairs.png)"></span>
        <div class="card lowest" v-for="(items, index) in this.minIndex" key="index"><span>... and have the most room for improvement in {{ items }} health</span>
          <div class="img" :style="'background-image: url(./img/icons/' + items + '.png)'"></div>
        </div>
        <div class="avr-score sp">
          <div class="title">{{ results.averScore + averScore }}
            <div class="status style1" v-if="this.averScore &gt;= 0 &amp;&amp; this.averScore &lt; 39">{{ results.averRange.D }}</div>
            <div class="status style2" v-if="this.averScore &gt;= 39 &amp;&amp; this.averScore &lt; 59">{{ results.averRange.C }}</div>
            <div class="status style3" v-if="this.averScore &gt;= 59 &amp;&amp; this.averScore &lt;= 79">{{ results.averRange.B }}</div>
            <div class="status style4" v-if="this.averScore &gt;= 80">{{ results.averRange.A }}</div>
          </div>
          <div class="content" v-if="this.averScore &gt;= 0 &amp;&amp; this.averScore &lt; 39" v-html="results.averContent.notwell"> </div>
          <div class="content" v-if="this.averScore &gt;= 39 &amp;&amp; this.averScore &lt; 59" v-html="results.averContent.average"></div>
          <div class="content" v-if="this.averScore &gt;= 59 &amp;&amp; this.averScore &lt;= 79" v-html="results.averContent.prettywell"></div>
          <div class="content" v-if="this.averScore &gt;= 80" v-html="results.averContent.verywell"></div>
        </div>
        <div class="avr-score">
          <div class="title">{{ results.balScore + balScore }}
            <div class="status style1" v-if="this.balScore &gt; 11">{{ results.balRange.B }}</div>
            <div class="status style4" v-if="this.balScore &lt;= 11">{{ results.balRange.A }}</div>
          </div>
          <div class="content" v-if="this.balScore &gt; 11" v-html="results.balContent.Unbalanced"> </div>
          <div class="content" v-if="this.balScore &lt;= 11" v-html="results.balContent.wellbalance"> </div>
        </div>
        <div class="about" :id="results.about.anchor">
          <div class="title" v-html="results.about.title"></div>
          <div class="content" v-html="results.about.content"></div>
        </div>
        <ul class="dimensions">
          <list :list="this.category"></list>
        </ul>
        <div class="balance">
          <div class="title" v-html="results.balance.title"></div>
          <div class="content" v-html="results.balance.content"></div>
        </div>
        <div class="other" :id="results.resources.anchor">
          <div class="title" v-html="results.resources.title"></div>
          <div class="content">{{ results.resources.content }}</div>
          <ul class="sp"><a v-for="(items, index) in results.TBC" key="index" :href="items.href" target="_blank">
              <div class="title">{{ items.title }}</div>
              <div class="img" :style="'background-image: url(' + items.img + ')'"></div></a></ul>
        </div>
        <div class="cut-area" id="cut-area">
          <p class="name" v-if="this.len === 'en'">{{ 'Hi ' + name }},</p>
          <p class="name" v-if="this.len === '中'">{{ '嗨 ' + name }},</p>
          <div class="title">{{ results.title }}</div>
          <div class="result-canvas">
            <canvas id="polarChartCutArea"></canvas>
          </div>
          <div class="instagram"><img src="./img/icons/instagram-c.png" alt="">
            <div class="detail">
              <p>Tag us on your Wellness Wheel</p>
              <p>@<a href="https://www.instagram.com/nesswellnesswheel">nesswellnesswheel</a>@<a href="https://www.instagram.com/ness.wellness">ness.wellness</a></p>
            </div>
          </div>
        </div>
        <div class="footer inline">
          <div class="container">
            <div class="instagram"><img src="./img/icons/instagram-c.png" alt="">
              <div class="detail">
                <p>Tag us on your Wellness Wheel</p>
                <p>@<a href="https://www.instagram.com/nesswellnesswheel">nesswellnesswheel</a>@<a href="https://www.instagram.com/ness.wellness">ness.wellness</a></p>
              </div>
            </div>
            <div class="logo-box"><span>Powered by</span>
              <div class="logo" style="background-image: url(./img/logo.png)"></div>
            </div>
            <div class="right">Wheel of Wellness by ness wellness© All rights reserved 2022</div>
          </div>
        </div>
      </div>
    </div>
    <script id="list" type="text/x-template">
      <li v-for="(items, i) in list" @click="openNot(i)" :key="i" :class="{active: i === activeItem}">
        <p><img :src="items.logo" alt="">{{ items.title }}</p>
        <div class="arrow" :style="i === activeItem?'background-image: url(./img/icons/up-arrow.png)':'background-image: url(./img/icons/down-arrow.png)'"></div>
        <transition name="slideDown"><span v-if="i === activeItem? show:!show">{{ items.info }}</span></transition>
      </li>
    </script>
    <script>
      const app = Vue.createApp({
      	data() {
      		return {
      			category: [],
      			results: [],
      			name: localStorage.name,
      			len: localStorage.len,
      			emo: localStorage.emo,
      			phy: localStorage.phy,
      			spi: localStorage.spi,
      			int: localStorage.int,
      			soc: localStorage.soc,
      			env: localStorage.env,
      			occ: localStorage.occ,
      			fin: localStorage.fin,
      			maxIndex: [],
      			minIndex: [],
      			check: localStorage.check
      		}
      	},
      	created: function() {
      		this.onCateCatch();
      		this.chartCheck();
      	},
      	mounted: function() {
      		var self = this;
      		var ctx = document.getElementById("polarChart").getContext("2d");
      		var	ctxCutArea = document.getElementById("polarChartCutArea").getContext("2d");
      
      		var data = {
      			datasets: [{
      				backgroundColor: [
      					"#d2f9f4",
      					"#d3f9d4",
      					"#eef8d4",
      					"#fbead6",
      					"#ffcddd",
      					"#f4e2f0",
      					"#e9d3f9",
      					"#bbebf7",
      				],
      				data: [this.int, this.soc, this.env, this.occ, this.fin, this.spi, this.phy, this.emo],
      				borderWidth: 1,
      				borderColor: '#f2f2f2',
      				label: 'My dataset'
      			}],
      			labels: ["Intellectual", "Social", "Environmental", "Occupational", "Financial", "Spiritual", "physical", "Emotional"]
      		}
      
      		var options = {
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
      					min: 0,
      					max: 10,
      					angleLines: {
      						max: 10,
      						display: true,
      						center: true,
      						color: '#d1d1d1'
      					},
      					ticks: {
      						display: false,
      						stepSize: 1,
      						color: 'black',
      						backdropColor: 'transparent',
      						z: 2,
      					},
      					grid: {
      						color: '#d1d1d1',
      						z: 2
      					}
      				}
      			},
      			animation: {
      				duration: 500,
      				easing: "easeOutQuart",
      				onComplete: function () {
      					let ctx = this.ctx;
      
      					ctx.font = '8px "Montserrat"';
      					ctx.textAlign = 'center';
      					ctx.textBaseline = 'bottom';
      	
      					//- console.log('!!!!');
      					//- console.log(this.getDatasetMeta(0));
      					let _meta = this.getDatasetMeta(0);
      					if(localStorage.check === 'true') {
      						let ctx = this.ctx;
      						ctx.font = '8px "Montserrat"';
      						ctx.textAlign = 'center';
      						ctx.textBaseline = 'bottom';
      		
      						//- console.log('!!!!');
      						//- console.log(this.getDatasetMeta(0));
      						let _meta = this.getDatasetMeta(0);
      						this.data.datasets.forEach(function (dataset) {
      
      							for (let i = 0; i < dataset.data.length; i++) {
      								let model = _meta.data[i],
      									mid_radius = model.innerRadius + (110 - model.innerRadius)/2 + 50,
      									start_angle = model.startAngle,
      									end_angle = model.endAngle,
      									mid_angle = start_angle + (end_angle - start_angle)/2;
      								//- console.log('=======' + i + '=======');
      								//- console.log('model.innerRadius :' + model.innerRadius);
      								//- console.log('model.outerRadius :' + model.outerRadius);
      								//- console.log('model.startAngle :' + model.startAngle);
      								//- console.log('model.endAngle :' + model.endAngle);
      								let x = mid_radius * Math.cos(mid_angle);
      								let y = mid_radius * Math.sin(mid_angle) + 8;
      								let t = dataset.data[i];
      								ctx.fillText(t, model.x + x, model.y + y);
      							}
      						});
      					}
      				}
      			}
      		};
      
      		var myChart = new Chart(ctx, {
      			type: 'polarArea',
      			data: data,
      			options: options
      		});
      
      		var myChart = new Chart(ctxCutArea, {
      			type: 'polarArea',
      			data: data,
      			options: options
      		})
      
      		var results = [this.emo, this.phy, this.spi, this.int, this.soc, this.env, this.occ, this.fin];
      		var maxIndex = [];
      		var minIndex = [];
      		var mMax = Math.max(...results);
      		var mMin = Math.min(...results);
      
      		results.forEach(function(element, i) {
      			var cate;
      			if(i == 0) {
      				cate = 'Emotional';
      			} else if(i == 1) {
      				cate = 'Physical';
      			} else if(i == 2) {
      				cate = 'Spiritual';
      			} else if(i == 3) {
      				cate = 'Intellectual';
      			} else if(i == 4) {
      				cate = 'Social';
      			} else if(i == 5) {
      				cate = 'Environmental';
      			} else if(i == 6) {
      				cate = 'Occupational';
      			} else if(i == 7) {
      				cate = 'Financial';
      			} else {
      				console.log('error')
      			}
      
      			if (element == mMax) {
      				maxIndex.push(cate);
      			}
      
      			if (element == mMin) {
      				minIndex.push(cate);
      			}
      		});
      
      		this.maxIndex = maxIndex;
      		this.minIndex = minIndex;
      	},
      	methods: {
      		onCateCatch: function() {
      			if(this.len === 'en') {
      				this.category = pageData.en.info.category;
      				this.results = pageData.en.results;
      			} else if(this.len === '中') {
      				this.category = pageData.ch.info.category;
      				this.results = pageData.ch.results;
      			} else {
      				this.category = pageData.en.info.category;
      				this.results = pageData.en.results;
      			}
      		},
      		chartCheck: function() {
      			if(localStorage.check === 'false') {
      				this.check = false;
      			} else if (localStorage.check === 'true') {
      				this.check = true;
      			} else {
      				this.check = true;
      				localStorage.check = this.check;
      			}
      		},
      		chartSwitch: function() {
      			this.check = !this.check;
      			localStorage.check = this.check;
      			location. reload();
      		},
      		          downloadImg: function() {
      		html2canvas(document.getElementById('cut-area')).then(function(canvas) {
      			// document.body.appendChild(canvas);
      			var dataUrl = canvas.toDataURL("image/png");
      			// console.log('dataUrl:' + dataUrl);
      			// saveImg(dataUrl)
      			var downloadUrl = dataUrl.replace("image/png","image/octet-stream");//圖片地址
      			var a = document.createElement("a"); //Create <a>
      			a.href = downloadUrl; //Image Base64 Goes here
      			a.download = Date.now() + ".png"; //File name Here
      			a.click(); 
      
      			});
      		} 
      	},
      	computed: {
      		averScore() {
      			var emoH = parseInt(this.emo*10),
      				phyH = parseInt(this.phy*10),
      				spiH = parseInt(this.spi*10),
      				intH = parseInt(this.int*10),
      				socH = parseInt(this.soc*10),
      				envH = parseInt(this.env*10),
      				occH = parseInt(this.occ*10),
      				finH = parseInt(this.fin*10),
      				aver = (emoH + phyH + spiH + intH + socH + envH + occH + finH);
      			return aver/8
      		},
      		balScore() {
      			var result = math.std([this.emo, this.phy, this.spi, this.int, this.soc, this.env, this.occ, this.fin])*10
      			return result.toFixed(2);
      		}
      	}
      });
      
      app.component('list', {
      	data() {
      		return {
      			activeItem: '',
      			show: true
      		}
      	},
      	template: '#list',
      	props:['list'],
      	methods: {
      		openNot: function(i) {
      			if(this.activeItem != i) {
      				this.activeItem = i;
      			} else {
      				this.activeItem = !this.activeItem;
      			}
      		}
      	}
      });
      
      app.mount('#app');
      
      function postToShare(fileName) {
      	// calling the API ...
      	var uri = 'http://uat.erduo.tw/wellness_wheel/results.php?img=' + fileName;
      	console.log(uri);
      	$.ajax({ 
      		type: "GET", 
      		url: uri,
      	});
      	var obj = {
      		method: 'share',
      		href: uri,
      		hashtag: "#nesswellnesswheel"    
      	};
      	FB.ui(obj);
      }
      
      function saveImg(){
      	html2canvas(document.getElementById('cut-area')).then(function(canvas) {
      		// document.body.appendChild(canvas);
      		var dataUrl = canvas.toDataURL("image/png");
      		// console.log('dataUrl:' + dataUrl);
      		$.ajax({ 
      			type: "POST", 
      			url: 'saveImg.php',
      			dataType: 'text',
      			data: {
      				img : dataUrl
      			},
      			async: false,
      			success(data){
      			console.log(data);
      			postToShare(data);
      			}
      		});
      	});
      	
      }
    </script>
  </body>
</html>