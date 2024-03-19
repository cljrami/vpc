<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .fancybox-arrow {
            position: absolute;
            top: 0;
            margin: 0 0 0 0;
            height: 100%;
            width: 49%;
            padding: 0;
            border: 0;
            outline: none;
            background: none;
            background-color: rgba(137, 255, 139, 0.4);
            cursor: pointer !important;
            z-index: 99995;
            opacity: 1;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            transition: opacity .25s;
        }

        .fancybox-arrow:hover {
            cursor: -webkit-image-set(url(Cursor-Right.png) 1x, url(Cursor-Rightx2.png) 2x), pointer;
        }
    </style>
</head>

<body>
    <div><a data-fancybox="gallery" data-src="https://lipsum.app/id/2/1024x768" data-caption="Optional caption,&lt;br /&gt;that can contain &lt;em&gt;HTML&lt;/em&gt; code"><img src="https://lipsum.app/id/2/200x150" /></a><a data-fancybox="gallery" data-src="https://lipsum.app/id/3/1024x768"><img src="https://lipsum.app/id/3/200x150" /></a><a data-fancybox="gallery" data-src="https://lipsum.app/id/4/1024x768"><img src="https://lipsum.app/id/4/200x150" /></a><a href="https://www.youtube.com/watch?v=z2X2HaTvkl8" data-fancybox="gallery"><img src="https://lipsum.app/id/4/200x150" /></a></div>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            Images: {
                zoom: false,
            }

            ,
            KeyboardEvent: {
                Escape: "close",
                Delete: "close",
                Backspace: "close",
                PageUp: "next",
                PageDown: "prev",
                ArrowUp: "prev",
                ArrowDown: "next",
                ArrowRight: "next",
                ArrowLeft: "prev",
            }


        });
    </script>
</body>

</html>