@extends('shuttle::admin')

@section('main')


<div class="welcome">
    <figure>
        
<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="1046" height="638.58364" viewBox="0 0 1046 638.58364" xmlns:xlink="http://www.w3.org/1999/xlink"><title>ready_to_print</title><path d="M238.23075,685.35346c8.56512,31.66183,37.90259,51.27079,37.90259,51.27079s15.45066-31.725,6.88554-63.38682-37.90258-51.27079-37.90258-51.27079S229.66563,653.69163,238.23075,685.35346Z" transform="translate(-77 -130.70818)" fill="#3f3d56"/><path d="M250.81659,678.549c23.50281,22.879,26.37351,58.04945,26.37351,58.04945s-35.23489-1.92384-58.7377-24.80288-26.37351-58.04945-26.37351-58.04945S227.31378,655.67,250.81659,678.549Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><rect x="113.4736" y="636.0293" width="827.6044" height="2.55433" fill="#2f2e41"/><path d="M287.7326,768.01465H254.52625V734.8083H287.7326Zm-30.652-2.55433h28.09768V737.36264H257.08059Z" transform="translate(-77 -130.70818)" fill="#3f3d56"/><rect y="25.32186" width="281.41977" height="281.41977" fill="#3f3d56"/><path d="M358.41977,226.0459V232.505a29.20519,29.20519,0,0,1-10.03614-11.3755c-3.74665-7.66268-3.628-16.49523-3.50929-25.03951.13566-10.15483.27121-19.73331-6.17091-25.972-7.08634-6.84908-18.4279-5.88275-29.39644-4.95025-1.28845.10172-2.57689.22029-3.84837.322-11.00248.83078-23.25956-1.94953-29.21-9.4597H283.674c5.44195,3.6618,13.76593,4.95025,21.41164,4.3738,1.23764-.08475,2.50912-.20343,3.78059-.30514,11.545-.9832,24.63265-2.10216,33.36349,6.35737,8.03571,7.7645,7.88308,18.91961,7.73056,29.70169-.11868,7.951-.22039,16.15626,3.00072,22.73392A23.24979,23.24979,0,0,0,358.41977,226.0459Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><path d="M358.41977,270.717v7.56108a32.155,32.155,0,0,0-4.13653-4.45865c-8.7477-7.71359-21.30993-9.40889-33.44824-11.07025-1.57661-.20354-3.11939-.42383-4.66207-.64423-19.68251-2.83122-31.88859-9.59545-37.2966-20.63187-3.74665-7.66268-3.628-16.49523-3.50928-25.03951.13565-10.15483.2712-19.73331-6.17092-25.972-7.08634-6.84908-18.4279-5.88275-29.39644-4.95025-1.28844.10171-2.57689.22029-3.84836.322-14.13885,1.068-30.36288-3.83129-32.58372-17.07158-.7628-4.5435.373-8.71387,2.05135-12.73172h5.56064c-1.8649,4.03482-3.25505,7.934-2.59386,11.88407,1.67833,10.10392,15.27467,13.73189,27.19257,12.83333,1.23764-.08475,2.50911-.20343,3.78059-.30514,11.545-.9832,24.63265-2.10216,33.36349,6.35737,8.0357,7.7645,7.88308,18.9196,7.73056,29.70169-.11868,7.951-.2204,16.15625,3.00071,22.73392,4.61117,9.426,15.54587,15.2577,33.44824,17.83459,1.5257.2204,3.06849.44079,4.61116.64422,12.88434,1.74621,26.22634,3.56009,36.14381,12.29093Q358.03837,270.33561,358.41977,270.717Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><path d="M358.41977,398.16964v10.44311c-6.12-6.51-11.23984-15.44416-15.156-26.61623-.83068-2.37336-1.62753-4.79773-2.42427-7.222-4.39087-13.27412-8.93426-26.98914-19.75028-35.75381-11.562-9.35809-28.125-11.42631-44.14557-13.42685-2.05135-.25423-4.1026-.50857-6.137-.77977-25.972-3.44151-42.06038-11.62973-49.19763-25.02264-4.95025-9.30718-4.79773-20.02149-4.64511-30.37975.18646-12.30789.373-23.93762-8.13742-31.4987-9.34112-8.307-24.31064-7.13725-38.7715-6.00132-1.71227.13555-3.40757.2712-5.06893.38988-18.66526,1.28845-40.07691-4.6451-42.99288-20.69964-1.441-7.86612,2.23781-14.83388,5.781-21.58114,2.03438-3.86533,3.96694-7.5441,4.95025-11.32459,2.06832-7.78147-.4916-16.54614-6.17092-22.66615h8.307a29.86869,29.86869,0,0,1,4.39077,24.12408c-1.16966,4.42471-3.33969,8.56125-5.44185,12.56223-3.23808,6.137-6.27263,11.93488-5.20458,17.86843,2.23781,12.24,20.15714,16.64785,35.8725,15.56284,1.64449-.11869,3.32283-.25434,5.00116-.37292,15.22386-1.2037,32.482-2.54295,44.01,7.71359,10.59562,9.4089,10.39219,22.93736,10.18877,36.00816-.13566,9.64626-.28828,19.59766,3.95,27.58256,6.08617,11.40933,20.53016,18.49567,44.14567,21.63194,2.00044.2713,4.03483.52554,6.0691.77987,17.02088,2.11913,34.60113,4.306,47.67193,14.90165,12.257,9.93454,17.08855,24.4971,21.73365,38.585.79685,2.4074,1.59359,4.78076,2.4074,7.13725A80.35091,80.35091,0,0,0,358.41977,398.16964Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><path d="M77,269.666c7.73057,9.358,24.12412,12.81647,38.82237,11.79929,1.66139-.11868,3.35669-.2543,5.06894-.38992,14.46091-1.13585,29.43041-2.30561,38.77151,6.00136,8.51041,7.561,8.32392,19.19079,8.13744,31.49867-.15258,10.35828-.30515,21.07258,4.64512,30.37977,7.13721,13.39287,23.22561,21.58117,49.1976,25.02263,2.03436.27125,4.08567.52554,6.137.77984,16.02058,2.00045,32.58366,4.06871,44.14561,13.42677,10.816,8.7647,15.35941,22.47968,19.75024,35.75387.79679,2.42428,1.59358,4.84856,2.42428,7.222.76288,2.18694,1.57663,4.27216,2.42428,6.28956h7.25588c-1.27148-2.76334-2.35647-5.52667-3.28888-8.17134-.81375-2.35647-1.61054-4.72989-2.40733-7.13721-4.64512-14.08795-9.47672-28.65057-21.73374-38.585-13.07076-10.59562-30.651-12.78256-47.67183-14.90168-2.03436-.2543-4.06872-.50859-6.06918-.77984-23.61552-3.13631-38.05948-10.22266-44.1456-21.632-4.23825-7.98486-4.08568-17.93627-3.95-27.58253.20343-13.07076.40687-26.59925-10.18876-36.00816-11.528-10.25657-28.78619-8.91728-44.01-7.71362-1.67835.11867-3.35669.2543-5.00113.373-15.71543,1.085-33.63475-3.32279-35.87255-15.56286-1.068-5.93355,1.96655-11.73147,5.20457-17.86846,2.10217-4.0009,4.27216-8.13744,5.44191-12.56217,3.18717-12.10444-2.18693-25.51426-13.08771-32.838v8.307c5.9505,6.137,8.663,15.10513,6.56081,23.073-.98327,3.78052-2.91592,7.45932-4.95028,11.32461-.54249,1.03413-1.085,2.05131-1.61053,3.1024Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><path d="M201.48585,437.44981h-7.03543c-.373-1.102-.72907-2.22084-1.102-3.33979-4.39088-13.27412-8.93427-26.98915-19.75029-35.75382-11.562-9.35809-28.125-11.4263-44.14557-13.42685-2.05135-.25423-4.1026-.50857-6.137-.77977C100.39512,381.11493,85.15439,374.36767,77,363.61953V346.75127a31.99435,31.99435,0,0,0,3.13626,9.66323c6.08618,11.40934,20.53016,18.49568,44.14568,21.63194,2.00044.27131,4.03482.52554,6.0691.77988,17.02087,2.11912,34.60112,4.306,47.67192,14.90164,12.257,9.93454,17.08855,24.49711,21.73366,38.58505C200.33306,434.04224,200.89254,435.75451,201.48585,437.44981Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><rect x="381.44246" y="25.32186" width="281.41977" height="281.41977" fill="#3f3d56"/><path d="M594.06645,176.37364a89.85757,89.85757,0,0,1-135.624,77.3226V156.03H591.7439A89.3085,89.3085,0,0,1,594.06645,176.37364Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><circle cx="589.96434" cy="101.61035" r="54.24959" fill="#38cab3"/><circle cx="467.90276" cy="216.89074" r="38.9919" fill="#38cab3"/><path d="M739.86224,391.33764v46.11217H684.07a38.99494,38.99494,0,0,1,55.79228-46.11217Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><circle cx="566.23015" cy="215.19544" r="10.1718" fill="#38cab3"/><rect x="764.58023" y="25.32186" width="281.41977" height="281.41977" fill="#3f3d56"/><path d="M978.89951,156.03V271.31043H841.58023v6.7812H985.68071V156.03Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><path d="M1111.3533,437.44981,1123,420.8867V409.10435l-19.93674,28.34546Zm-47.29891-121.34959-62.404,88.74891,46.36651,32.60068h11.78225l-48.70593-34.24507,54.60565-77.66169L1123,365.84036v-8.29Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><path d="M960.25122,304.86038l-35.95735,35.95734L960.25122,376.775l35.95734-35.95725Zm-26.37887,35.95734,26.37887-26.37886,26.37886,26.37886-26.37886,26.37886Z" transform="translate(-77 -130.70818)" fill="#38cab3"/><circle cx="137.93407" cy="25.54335" r="25.54335" fill="#f2f2f2"/><circle cx="532.57875" cy="25.54335" r="25.54335" fill="#f2f2f2"/><circle cx="909.3431" cy="25.54335" r="25.54335" fill="#f2f2f2"/><circle cx="506.39683" cy="150.06716" r="24.26618" fill="#ffb8b8"/><path d="M570.62515,292.26984s6.38584,33.20635,3.8315,39.59219,35.76069-2.55434,35.76069-2.55434-7.663-33.20635-6.38584-40.86935S570.62515,292.26984,570.62515,292.26984Z" transform="translate(-77 -130.70818)" fill="#ffb8b8"/><polygon points="451.479 276.507 454.033 310.99 466.71 365.146 470.636 379.957 477.022 356.968 470.636 304.604 468.467 281.029 451.479 276.507" fill="#ffb8b8"/><path d="M662.5812,402.10623v35.76068s-3.83151,45.978-11.49451,57.47253-10.21734-45.978-10.21734-45.978l6.00472-42.14652Z" transform="translate(-77 -130.70818)" fill="#ffb8b8"/><path d="M548.91331,513.21978s-6.38584,7.663-1.27717,85.57021S545.08181,732.89255,561.685,732.89255c0,0-5.10867,16.60318,8.94017,17.88034s20.43468,2.55434,21.71185-1.27716,3.8315-21.71185,0-21.71185c0,0,0,5.10867,2.55433-15.326s2.55434-117.49939,8.94017-130.27107L624.26618,629.442s0,21.71185,3.8315,31.92918,10.21734,68.967,10.21734,68.967l-1.27717,8.94017s30.652,5.10867,31.92918,0,1.27717-12.77167,0-15.326-1.27716-2.55433,1.27717-7.663,2.55433-8.94017,1.27717-12.77168-1.27717-86.84737-1.27717-86.84737-2.55433-100.89622-17.88034-106.00488S548.91331,513.21978,548.91331,513.21978Z" transform="translate(-77 -130.70818)" fill="#2f2e41"/><path d="M565.51648,740.55556,555.29915,758.4359s-15.9646-5.74726-12.77168,8.94017c27.4591,1.91575,46.61661-.63859,46.61661-.63859s6.38583,2.55434,7.663-1.27716-3.19292-17.24176-7.02442-17.24176S565.51648,740.55556,565.51648,740.55556Z" transform="translate(-77 -130.70818)" fill="#2f2e41"/><path d="M639.59219,735.44689s-10.21734,22.989-6.38584,24.26617,38.315,6.38584,40.86935,7.663,15.326,2.55433,16.60318-5.10867-6.38584-10.21734-6.38584-10.21734-14.04884-2.55433-17.88034-15.326S639.59219,735.44689,639.59219,735.44689Z" transform="translate(-77 -130.70818)" fill="#2f2e41"/><path d="M612.77167,325.47619s-34.48351-6.38584-42.14652,0S531.033,344.6337,531.033,351.01954s16.60317,68.967,16.60317,68.967-8.94017,94.51038,0,97.06471,24.26618-5.10867,42.14652,3.8315,68.967-7.663,68.967-7.663-19.1575-81.73871-14.04884-97.06471S653.641,348.4652,653.641,348.4652,631.92918,325.47619,612.77167,325.47619Z" transform="translate(-77 -130.70818)" fill="#8985a8"/><path d="M539.97314,347.188l-8.94017,2.55434s-19.15751,60.02686-11.49451,62.5812,29.37485,7.663,31.92918,7.663S539.97314,347.188,539.97314,347.188Z" transform="translate(-77 -130.70818)" fill="#8985a8"/><path d="M633.20635,340.8022l20.43468,7.663s26.82051,49.80953,20.43467,56.19536-34.48351,12.77167-34.48351,12.77167Z" transform="translate(-77 -130.70818)" fill="#8985a8"/><path d="M582.65976,250.80311a13.71573,13.71573,0,0,0-6.07019.268,15.82759,15.82759,0,0,0-4.31392,2.82985,50.4916,50.4916,0,0,1-7.37585,4.88674c-2.06956,1.12349-4.29419,2.16336-5.739,4.0229a12.21131,12.21131,0,0,0-1.61977,3.06606,36.74031,36.74031,0,0,0-1.93172,19.99594,9.191,9.191,0,0,0,.85074,2.74569c1.3274,2.44565,4.2592,3.40946,6.72893,4.6915,4.689,2.43407,8.24343,6.5327,12.0893,10.15493a23.63371,23.63371,0,0,0,4.77654,3.68109c5.48669,2.99147,12.19306,2.01557,18.35208.95775a3.30733,3.30733,0,0,0,3.30082-3.33887l4.86152-21.86575a35.67314,35.67314,0,0,0,1.246-9.94447c-.33919-5.30791-3.21279-12.66061-7.10829-16.431C596.168,252.1303,588.59285,251.43123,582.65976,250.80311Z" transform="translate(-77 -130.70818)" fill="#2f2e41"/><circle cx="341.3101" cy="607.96891" r="10.07861" fill="#38cab3"/><path d="M418.3101,767.79308a29.116,29.116,0,1,1,29.116-29.116A29.14864,29.14864,0,0,1,418.3101,767.79308Zm0-55.99228a26.87629,26.87629,0,1,0,26.87629,26.87629A26.90708,26.90708,0,0,0,418.3101,711.8008Z" transform="translate(-77 -130.70818)" fill="#2f2e41"/><circle cx="831.74234" cy="609.24608" r="10.07861" fill="#38cab3"/><path d="M908.74234,769.07024a29.116,29.116,0,1,1,29.116-29.116A29.14864,29.14864,0,0,1,908.74234,769.07024Zm0-55.99227a26.87629,26.87629,0,1,0,26.87629,26.87629A26.90708,26.90708,0,0,0,908.74234,713.078Z" transform="translate(-77 -130.70818)" fill="#2f2e41"/><circle cx="831.74234" cy="553.05072" r="10.07861" fill="#38cab3"/><path d="M908.74234,712.87488a29.116,29.116,0,1,1,29.116-29.116A29.14864,29.14864,0,0,1,908.74234,712.87488Zm0-55.99227a26.87629,26.87629,0,1,0,26.87629,26.87629A26.90708,26.90708,0,0,0,908.74234,656.88261Z" transform="translate(-77 -130.70818)" fill="#2f2e41"/></svg>
    </figure>
</div>
<!-- /.welcome -->






@stop

{{-- @push('js')
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
@endpush --}}