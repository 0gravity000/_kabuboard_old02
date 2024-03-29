<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>kabuboard</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Favicons -->
    <!-- 
	<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
	<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
	<link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
	<link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
	<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico">
	<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
	<meta name="theme-color" content="#563d7c">
	 -->

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="/">
              <span data-feather="home"></span>
              TOP
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/meigara">
              <span data-feather="file"></span>
              銘柄一覧
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/realtime_checking">
              <span data-feather="shopping-cart"></span>
              リアルタイム銘柄監視
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/realtime_history">
              <span data-feather="users"></span>
              履歴
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>シグナル（日足）</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="/signal">
              <span data-feather="file-text"></span>
              シグナル（日足）
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">シグナル（日足）</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
              <a href="/signal_akasanpei">赤三兵</a>
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
              <a href="/signal_kurosanpei">黒三兵</a>
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
              <a href="/signal_volume">出来高急増</a>
            </button>
          </div>
        </div>
      </div>
	  <!--
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
	  -->
      <h2>黒三兵</h2>
      <h3>
        基準日：{{ $date_array[0] }}
      </h3>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>コード</th>
            <th>銘柄名</th>
            <th>⊿：現在値（円）</th>
            <th>⊿：変化率（%）</th>
            <th>現在値（円）</th>
            <th>現在値：1営業日前</th>
            <th>現在値：2営業日前</th>
            <th>現在値：3営業日前</th>
            <th>#</th>
        </tr>
        </thead>
        <tbody>
          @foreach($kurosan_disp_array as $kurosan_elm)
          @php
          @endphp
            <tr>
            <td>{{ $kurosan_elm[1] }}</td>
            <td>{{ $kurosan_elm[2] }}</td>
            <td>{{ $kurosan_elm[3] }}</td>
            <td>{{ $kurosan_elm[4] }}</td>
            <td>{{ $kurosan_elm[5] }}</td>
            <td>{{ $kurosan_elm[6] }}</td>
            <td>{{ $kurosan_elm[7] }}</td>
            <td>{{ $kurosan_elm[8] }}</td>
            <td>#</td>
            </tr>
          @endforeach
        </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script src="/js/dashboard.js"></script></body>
</html>
