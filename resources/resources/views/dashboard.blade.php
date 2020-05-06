@extends('master')
@section('Judul','Home')
@section('headlink')
<link rel="stylesheet" type="text/css" href="{{asset('/css/nice-select.css')}}">
<!-- <link rel="stylesheet" type="text/css" href="{{asset('/css/style.css')}}"> -->
@endsection
@section('konten')
<div class="row align-items-center mb-4">
	<div class="col-8">
		<div class="card shadow">
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col-4">
					  <div class="text-center">
					    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" src="img/welcome.svg" alt="">
					  </div>
					</div>
					<div class="col-8">
						<div class="row">
				  			<span class="h3 text-center font-weight-bold">Welcome Back!
				  			</span>
						</div>
						<div class="row">
				  			<span class="h4 text-center font-weight-light">{{ @session('name') }} {{@session('last_name') }}
				  			</span>
						</div>
					</div>
			  	</div>
			</div>
		</div>
	</div>
	  <div class="col-4">
	  	<div class="row">
	      <div class="card border-left-success shadow w-100 mx-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">total Produk Terjual</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800"><span class="counter" id="productsale">56</span></div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-calendar fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  	<div class="row mt-2">
	      <div class="card border-left-success shadow w-100 mx-2">
	        <div class="card-body">
	          <div class="row align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Produk Terjual Bulan ini</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800" id="monproductsale">0</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-calendar fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	 </div>
</div>
<div class="row pt-2">
	<div class="col mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Penjualan Bulan Ini</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="monthsale">0</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Penjualan Tahun Ini</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="yearsale">0</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penjualan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalsale">0</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-money-bill-wave-alt fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
	<!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan</h6>
          <a href="{{ url('/sales/print-pdf') }}"><button type="button" class="btn btn-primary">Download Laporan</button></a>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <select class="right" id="pilihTahun">
                @foreach($years as $y)
                  @if($y->tahun == $tahunini)
                  <option value="{{$y->tahun}}" selected>{{$y->tahun}}</option>
                  @else
                  <option value="{{$y->tahun}}">{{$y->tahun}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="chart-area">
              <canvas id="myAreaChart"></canvas>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-9">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Tahunan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Bulanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Mingguan</a>
            </li>
          </ul>
          </div>
          <div class="col-3">

          </div>
          </div> -->
         <!--  <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div class="row">
                <div class="col-12">
                  <select class="right" id="pilihBulan">
                    @foreach($month as $y)
                      @if($y->bulan == $bulanini)
                      <option value="{{$y->bulan}}" selected>{{$y->bulan}}</option>
                      @else
                      <option value="{{$y->bulan}}">{{$y->bulan}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="chart-area">
                  <canvas id="myAreaChartBulan"></canvas>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
              <div class="row">
                <div class="col-12">
                  <select class="right" id="pilihMinggu">

                    <option>mingguan</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="chart-area">
                  <canvas id="myAreaChartMinggu"></canvas>
                </div>
              </div>
            </div>
          </div> -->

        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Penjualan Tertinggi</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <canvas id="myPieChart"></canvas>
          </div>
          <div class="mt-4 text-center small">
            <span class="mr-2">
              <i class="fas fa-circle mr-1" style="color: #4056F4"></i><span id="cat1"> Direct</span>
            </span>
            <span class="mr-2">
              <i class="fas fa-circle mr-1" style="color: #FF715B"></i><span id="cat2"> Social</span>
            </span>
            <span class="mr-2">
              <i class="fas fa-circle mr-1" style="color: #F9CB40"></i><span id="cat3"> Referal</span>
            </span>
            <span class="mr-2">
              <i class="fas fa-circle mr-1" style="color: #4C5B5C"></i><span id="cat4"> Referal</span>
            </span>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('bottom')
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  <script src="{{asset('/js/jquery.nice-select.js')}}"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script> -->
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script> -->
  <script src="{{asset('/admin/vendor/chart.js/Chart.min.js')}}"></script>
  <!-- <script src="/js/counterUp.js"></script> -->
  <script>
    var baseurl = '{{URL::to('')}}';
    $(document).ready(function() {
      $('select').niceSelect();
      $('select').niceSelect('update');
    });

    var earnings=[];
    var label=[];
    $.ajax({
        url: baseurl+'/getEarning/'+$("#pilihTahun").val(),
        method: 'GET',
        success: function(data) {
          setData(data.earning,data.labels,"myAreaChart");
        },
        error: function(data){
        }
    });

    function setData(earning,month,id){
      for(var i in earning)
          earnings[i] = earning[i];
      for(var i in month)
          label.push(month[i]["namabulan"]);
      buildLineChart(earnings,label,id);
    }

    $("#pilihBulan").click(function(){
      var month = $("#pilihBulan").val();
      $.ajax({
          url: baseurl+'/getEarningBulan/'+month,
          method: 'GET',
          success: function(data) {
            setDataBulan(data.earning,data.labels,"myAreaChartBulan");
          },
          error: function(data){
          }
      });
    });

    var month = $("#pilihBulan").val();
      $.ajax({
        url: baseurl+'/getEarningBulan/'+month,
        method: 'GET',
        success: function(data) {
          setDataBulan(data.earning,data.labels,"myAreaChartBulan");
        },
        error: function(data){
        }
      });

    function setDataBulan(earning,month,id){
      for(var i in earning)
          earnings[i] = earning[i];
      for(var i=0;i<4;i++){
        label[i] = "Minggu ke-"+i;
        //label.push(month[i]["DATE_FORMAT(nota_date,\"%b\")"]);
      }
      buildLineChart(earnings,label,id);
    }

  </script>
  <script src="{{asset('/admin/js/demo/chart-area.js')}}"></script>
  <script src="{{asset('/admin/js/demo/chart-area-bulan.js')}}"></script>
  <script src="{{asset('/admin/js/demo/chart-pie.js')}}"></script>
  <script src="{{asset('/js/getSaleInfo.js')}}"></script>
@endsection