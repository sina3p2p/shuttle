@extends('shuttle::admin')

@section('main')
<div id="main-ctr">
{{--  <svg xmlns="http://www.w3.org/2000/svg" width="294" height="241" viewBox="0 0 294 241">--}}
{{--    <g id="group" fill="none" fill-rule="evenodd">--}}
{{--      <g id="smile">--}}
{{--        <path id="smile-up" stroke="#da251c" stroke-width="30" d="M238.797 75.04C222.935 40.772 188.243 17 148 17c-39.62 0-73.857 23.04-90.046 56.453" stroke-linecap="round"/>--}}
{{--        <path id="smile-down" stroke="#da251c" stroke-width="30" d="M238.843 166c-15.863 34.268-50.554 58.04-90.797 58.04-39.62 0-73.857-23.04-90.046-56.453" stroke-linecap="round"/>--}}
{{--        <path id="bg" fill="#da251c" d="M43 2h211v237H43z" opacity=".1"/>--}}
{{--      </g>--}}
{{--      <path id="eye-left" fill="#da251c" d="M148 173c29.27 0 53-23.73 53-53s-23.73-53-53-53c-4.956 0-9.753.68-14.303 1.952C111.374 75.194 95 95.685 95 120c0 29.27 23.73 53 53 53z"/>--}}
{{--      <path id="eye-right" fill="#da251c" d="M148 173c29.27 0 53-23.73 53-53s-23.73-53-53-53c-4.016 0-7.927.447-11.687 1.293C112.665 73.615 95 94.745 95 120c0 29.27 23.73 53 53 53z"/>--}}
{{--      <path id="eye-to-left" fill="#da251c" d="M106 143c12.15 0 22-9.85 22-22s-9.85-22-22-22c-2.028 0-3.992.274-5.857.788C90.836 102.352 84 110.878 84 121c0 12.15 9.85 22 22 22z"/>--}}
{{--      <path id="eye-to-right" fill="#da251c" d="M187 143c12.15 0 22-9.85 22-22s-9.85-22-22-22c-3.286 0-6.404.72-9.204 2.012C170.242 104.496 165 112.136 165 121c0 12.15 9.85 22 22 22z"/>--}}
{{--    </g>--}}
{{--  </svg>--}}
{{--  <h1 class="hello">მოგესალმებით, მომხმარებელო</h1>--}}
    <lottie-player src="{{asset('shuttle/analytics_loader.json')}}" mode="bounce" background="transparent"  speed="1.2"  style="width: 500px; height: 500px;"  loop  autoplay></lottie-player>
    <h1 class="hello">Analytics data loading 😉 ...</h1>
</div>
<div id="analytics-info" style="display: none">
    <div class="row">
        <div class="col-md-6 col-sm-12 mb-4">
            <div class="card dashboard-filled-line-chart">
                <div class="card-body ">
                    <div class="float-left float-none-xs">
                        <div class="d-inline-block">
                            <h5 class="d-inline">Today Website Visits</h5>
                            <span class="text-muted text-small d-block">Unique Visitors</span>
                        </div>
                    </div>
                </div>
                <div class="chart card-body pt-0">
                    <canvas id="todayVisitChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12 mb-4">
            <div class="card dashboard-filled-line-chart">
                <div class="card-body ">
                    <div class="float-left float-none-xs">
                        <div class="d-inline-block">
                            <h5 class="d-inline">Yesterday Website Visits</h5>
                            <span class="text-muted text-small d-block">Unique Visitors</span>
                        </div>
                    </div>
                </div>
                <div class="chart card-body pt-0">
                    <canvas id="yesterdayVisitChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 col-sm-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Browsers</h5>
                    <div class="dashboard-donut-chart">
                        <canvas id="browserChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body" id="dashboard-progress">
                    <h5 class="card-title">Channels</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('js')
<script src="{{asset('shuttle/js/vendor/Chart.bundle.min.js')}}"></script>
<script src="{{asset('shuttle/js/vendor/chartjs-plugin-datalabels.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
  <script>
      var rootStyle = getComputedStyle(document.body);
      var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
      var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
      var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
      var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
      var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
      var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
      var themeColor1_10 = rootStyle
          .getPropertyValue("--theme-color-1-10")
          .trim();
      var themeColor2_10 = rootStyle
          .getPropertyValue("--theme-color-2-10")
          .trim();
      var themeColor3_10 = rootStyle
          .getPropertyValue("--theme-color-3-10")
          .trim();
      var themeColor4_10 = rootStyle
          .getPropertyValue("--theme-color-4-10")
          .trim();

      var themeColor5_10 = rootStyle
          .getPropertyValue("--theme-color-5-10")
          .trim();
      var themeColor6_10 = rootStyle
          .getPropertyValue("--theme-color-6-10")
          .trim();

      var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
      var foregroundColor = rootStyle
          .getPropertyValue("--foreground-color")
          .trim();
      var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

      var chartTooltip = {
          backgroundColor: foregroundColor,
          titleFontColor: primaryColor,
          borderColor: separatorColor,
          borderWidth: 0.5,
          bodyFontColor: primaryColor,
          bodySpacing: 10,
          xPadding: 15,
          yPadding: 15,
          cornerRadius: 0.15,
          displayColors: false
      };

      var centerTextPlugin = {
          afterDatasetsUpdate: function(chart) {},
          beforeDraw: function(chart) {
              var width = chart.chartArea.right;
              var height = chart.chartArea.bottom;
              var ctx = chart.chart.ctx;
              ctx.restore();

              var activeLabel = chart.data.labels[0];
              var activeValue = chart.data.datasets[0].data[0];
              var dataset = chart.data.datasets[0];
              var meta = dataset._meta[Object.keys(dataset._meta)[0]];
              var total = meta.total;

              var activePercentage = parseFloat(
                  ((activeValue / total) * 100).toFixed(1)
              );
              activePercentage = chart.legend.legendItems[0].hidden
                  ? 0
                  : activePercentage;

              if (chart.pointAvailable) {
                  activeLabel = chart.data.labels[chart.pointIndex];
                  activeValue =
                      chart.data.datasets[chart.pointDataIndex].data[chart.pointIndex];

                  dataset = chart.data.datasets[chart.pointDataIndex];
                  meta = dataset._meta[Object.keys(dataset._meta)[0]];
                  total = meta.total;
                  activePercentage = parseFloat(
                      ((activeValue / total) * 100).toFixed(1)
                  );
                  activePercentage = chart.legend.legendItems[chart.pointIndex].hidden
                      ? 0
                      : activePercentage;
              }

              ctx.font = "36px" + " Nunito, sans-serif";
              ctx.fillStyle = primaryColor;
              ctx.textBaseline = "middle";

              var text = activePercentage + "%",
                  textX = Math.round((width - ctx.measureText(text).width) / 2),
                  textY = height / 2;
              ctx.fillText(text, textX, textY);

              ctx.font = "14px" + " Nunito, sans-serif";
              ctx.textBaseline = "middle";

              var text2 = activeLabel,
                  textX = Math.round((width - ctx.measureText(text2).width) / 2),
                  textY = height / 2 - 30;
              ctx.fillText(text2, textX, textY);

              ctx.save();
          },
          beforeEvent: function(chart, event, options) {
              var firstPoint = chart.getElementAtEvent(event)[0];

              if (firstPoint) {
                  chart.pointIndex = firstPoint._index;
                  chart.pointDataIndex = firstPoint._datasetIndex;
                  chart.pointAvailable = true;
              }
          }
      };

      $.ajax({
          method: 'post',
          url: "{{route('shuttle.analytics')}}",
          success: function (res) {
             new Chart(document.getElementById("browserChart"), {
                  plugins: [centerTextPlugin],
                  type: "DoughnutWithShadow",
                  data: {
                      labels: _.pluck(res.browser, 'label'),
                      datasets: [
                          {
                              label: "",
                              backgroundColor: _.pluck(res.browser, 'color'),
                              data: _.pluck(res.browser, 'value')
                          }
                      ]
                  },
                  draw: function() {},
                  options: {
                      plugins: {
                          datalabels: {
                              display: false
                          }
                      },
                      responsive: true,
                      maintainAspectRatio: false,
                      cutoutPercentage: 80,
                      title: {
                          display: false
                      },
                      layout: {
                          padding: {
                              bottom: 20
                          }
                      },
                      legend: {
                          position: "bottom",
                          labels: {
                              padding: 30,
                              usePointStyle: true,
                              fontSize: 12
                          }
                      },
                      tooltips: chartTooltip
                  }
              });

              var channel_html = "";
              res.channels.channels.map(function (ch) {
                  channel_html += '<div class="mb-4"><p class="mb-2">'+ch.title+'<span class="float-right text-muted">'+ch.sessions+'/'+res.channels.all+'</span></p><div class="progress">\n' +
                      '<div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: '+(ch.sessions * 100 / res.channels.all)+'%;"></div></div></div>'
              });
              $('div#dashboard-progress').append(channel_html);
                  new Chart(document.getElementById("todayVisitChart").getContext("2d"), {
                      type: "LineWithShadow",
                      options: {
                          plugins: {
                              datalabels: {
                                  display: false
                              }
                          },
                          responsive: true,
                          maintainAspectRatio: false,
                          scales: {
                              yAxes: [
                                  {
                                      gridLines: {
                                          display: true,
                                          lineWidth: 1,
                                          color: "rgba(0,0,0,0.1)",
                                          drawBorder: false
                                      },
                                  }
                              ],
                              xAxes: [
                                  {
                                      gridLines: {
                                          display: false
                                      }
                                  }
                              ]
                          },
                          legend: {
                              display: false
                          },
                          tooltips: chartTooltip
                      },
                      data: {
                          labels: ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
                          datasets: [
                              {
                                  label: "",
                                  data: _.pluck(res.today, 'sessions'),
                                  borderColor: themeColor1,
                                  pointBackgroundColor: foregroundColor,
                                  pointBorderColor: themeColor1,
                                  pointHoverBackgroundColor: themeColor1,
                                  pointHoverBorderColor: foregroundColor,
                                  pointRadius: 4,
                                  pointBorderWidth: 2,
                                  pointHoverRadius: 5,
                                  fill: true,
                                  borderWidth: 2,
                                  backgroundColor: themeColor1_10
                              }
                          ]
                      }
                  });

                  var myChart = new Chart(document.getElementById("yesterdayVisitChart").getContext("2d"), {
                      type: "LineWithShadow",
                      options: {
                          plugins: {
                              datalabels: {
                                  display: false
                              }
                          },
                          responsive: true,
                          maintainAspectRatio: false,
                          scales: {
                              yAxes: [
                                  {
                                      gridLines: {
                                          display: true,
                                          lineWidth: 1,
                                          color: "rgba(0,0,0,0.1)",
                                          drawBorder: false
                                      },
                                  }
                              ],
                              xAxes: [
                                  {
                                      gridLines: {
                                          display: false
                                      }
                                  }
                              ]
                          },
                          legend: {
                              display: false
                          },
                          tooltips: chartTooltip
                      },
                      data: {
                          labels: ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
                          datasets: [
                              {
                                  label: "",
                                  data: _.pluck(res.yesterday, 'sessions'),
                                  borderColor: themeColor1,
                                  pointBackgroundColor: foregroundColor,
                                  pointBorderColor: themeColor1,
                                  pointHoverBackgroundColor: themeColor1,
                                  pointHoverBorderColor: foregroundColor,
                                  pointRadius: 4,
                                  pointBorderWidth: 2,
                                  pointHoverRadius: 5,
                                  fill: true,
                                  borderWidth: 2,
                                  backgroundColor: themeColor1_10
                              }
                          ]
                      }
                  });

                  $("#main-ctr").remove();

                  $("#analytics-info").show();

              }
      });

  </script>
@endpush

