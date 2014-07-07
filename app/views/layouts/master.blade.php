<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    {{ HTML::style('css/main.css'); }}
    {{ HTML::style('css/themes/default/jquery.mobile.external-png-1.4.2.min.css'); }}
    {{ HTML::style('css/themes/default/jquery.mobile.icons-1.4.2.min.css'); }}
    {{ HTML::style('css/themes/default/jquery.mobile.inline-png-1.4.2.min.css'); }}
    {{ HTML::style('css/themes/default/jquery.mobile.inline-svg-1.4.2.min.css'); }}
    {{ HTML::style('css/themes/default/jquery.mobile.structure-1.4.2.min.css'); }}
    {{ HTML::style('css/themes/default/jquery.mobile.theme-1.4.2.min.css'); }}
    {{ HTML::style('css/themes/default/jquery.mobile-1.4.2.min.css'); }}
    {{ HTML::style('css/main.css'); }}
    {{ HTML::script('js/googletrackingcode.js'); }}
    {{ HTML::script('js/jquery.js'); }}
    {{ HTML::script('js/jquery.mobile-1.4.2.min.js'); }}
    {{ HTML::script('js/delete_link.js'); }}
    <title>DrJuJur</title>
	
	<script type="text/javascript">
        $(document).on("pagebeforeshow", function () {
            $.mobile.ajaxEnabled = false;
        });
    </script>
	
</head>
<body>

@yield('content')

</body>
</html>
