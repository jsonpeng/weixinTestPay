
<html >
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    <script src="https://cdn.bootcss.com/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript">
        console.log($('#searchlist').contents().find('#saveBtn'));
        $('.content').html($("#searchlist").contents());
    </script>
    </head>
    <body>
      {{--   <iframe name="order_list" id="searchlist" src="https://m.kuaidi100.com/index_all.html?type={!! $type !!}&postid={!! $postid !!}"  style="width: 100%;height:1000px;" /> --}}

        <div class="flex-center position-ref full-height">

        </div>

        <div class="content">
        </div>


      </body>
</html>
