<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>@yield('titulo','Salí')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{asset('/pages/ico/60.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/pages/ico/76.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/pages/ico/120.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/pages/ico/152.png')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('/assets/css/images/favicon.ico')}}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{asset('/assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/plugins/boostrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('/assets/plugins/bootstrap-select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('/assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('/pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{asset('/pages/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <!--[if lte IE 9]>
        <link href="pages/css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="{{asset('pages/css/windows.chrome.fix.css')}}" />'
    }
    </script>
  </head>
  <body class="fixed-header ">
    <div class="login-wrapper ">
      <!-- START Login Background Pic Wrapper-->
      <div class="bg-pic">
        <!-- START Background Pic-->
        <img src="{{isset($config_page->background) && trim($config_page->background) != "" ? asset($config_page->background) : asset('/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}" data-src="{{isset($config_page->background) && trim($config_page->background) != "" ? asset($config_page->background) : asset('/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}" data-src-retina="{{isset($config_page->background) && trim($config_page->background) != "" ? asset($config_page->background) : asset('/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}" alt="" class="lazy">
        <!-- END Background Pic-->
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          <h2 class="semi-bold text-white">{{isset($config_page->principal_text->primary) && trim($config_page->principal_text->primary) != "" ? $config_page->principal_text->primary : ""}}</h2>
          <p class="small">
            {{isset($config_page->principal_text->secondary) && trim($config_page->principal_text->secondary) != "" ? $config_page->principal_text->secondary : ""}}
          </p>
        </div>
        <!-- END Background Caption-->
      </div>
      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <img src="{{asset('/assets/images/logo.png')}}" alt="logo" data-src="{{asset('/assets/images/logo.png')}}" data-src-retina="assets/images/logo.png" width="78" height="22">
          <p class="p-t-35">Iniciar Sesión</p>
          <!-- START Login Form -->

          <form id="form-login" class="p-t-15" role="form" action="{{url('validar/session.html')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Correo</label>
              <div class="controls">
                <input type="text" name="email" placeholder="Dirección email" class="form-control email" required>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Contraseña</label>
              <div class="controls">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 no-padding">
                <div class="checkbox ">
                  <input type="checkbox" id="checkbox1" name="remember">
                  <label for="checkbox1">Mantener Sesión</label>
                </div>
              </div>
              <!-- <div class="col-md-6 text-right">
                <a href="#" class="text-info small">Help? Contact Support</a>
              </div> -->
            </div>
            <!-- END Form Control-->
            <button class="btn btn-primary btn-cons m-t-10" type="submit">Iniciar Sesión</button>
          </form>
          <!--END Login Form-->
          <div class="pull-bottom sm-pull-bottom">
            <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
              
              <div class="col-sm-9 no-padding m-t-10">
                <p>
                  <small>
                    {{isset($config_page->form_footer->text) && trim($config_page->form_footer->text) != "" ? $config_page->form_footer->text : ""}}
                  </small>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>
    
    <!-- BEGIN VENDOR JS -->
    <script src="{{asset('/assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery/jquery-1.11.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/boostrapv3/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-bez/jquery.bez.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/plugins/bootstrap-select2/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/plugins/classie/classie.js')}}"></script>
    <script src="{{asset('/assets/plugins/switchery/js/switchery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <script src="{{asset('/pages/js/pages.min.js')}}"></script>
    <script>
    $(function()
    {
      $('#form-login').validate()
    })
    </script>
  </body>
</html>