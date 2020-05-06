// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
catname=[];
sales=[];

$.ajax({
    url: baseurl+'/getTopSell',
    method: 'GET',
    success: function(data) {
      setPieData(data.top_cat);
    },
    error: function(data){
    }
});

function setPieData(topcat){
  for(var i in topcat)
      catname[i] = topcat[i]["category_name"];
  for(var i in topcat)
      sales.push(topcat[i]["total_penjualan"]);
  buildPieChart(sales,catname);
  $("#cat1").html(catname[0]);
  $("#cat2").html(catname[1]);
  $("#cat3").html(catname[2]);
  $("#cat4").html(catname[3]);
}
// Pie Chart Example
function buildPieChart(percent,label){
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: label,
    datasets: [{
      data: percent,
      backgroundColor: ['#4056F4', '#FF715B', '#F9CB40','#4C5B5C'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf','#343a40'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
}