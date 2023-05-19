<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset={$const.encodingHTML}"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <link href="{$factory->stylesheet_dir}/index_old.css" rel="stylesheet" type="text/css"/>
    <link href="{$factory->stylesheet_dir}/fonts_old.css" rel="stylesheet" type="text/css"/>
    <link href="{$factory->stylesheet_dir}smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <style>
        div.container {
            display: block;
            width: 1320px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <link rel="shortcut icon" href="{$factory->img_admin_dir}admin_logo.ico"/>
    <title>{$const.name}&nbsp;{$const.major}{$const.minor} - {$currentSection.description}</title>
    <script src="{$factory->js_dir}/index_old.js" type="text/javascript"></script>
    <script src="{$factory->js_dir}/jquery.min.js" type="text/javascript"></script>
    <script src="{$factory->js_dir}/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{$factory->js_dir}/jquery.flot.min.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
    Вы известны как
    <span style="font-style: italic">
                    <b>{$smarty.session.user.fio}</b>
    </span>
    <a href="./auth.php?logout" class="av">
        [Выход]
    </a>
    <div style="float:right;">
        <a href="https://ru.wikipedia.org">Информационный портал<sup style="color:red">new</sup></a>
    </div>
    <div style="display:table; border:1px solid #ccc; margin-bottom: 10px; width:100%;" class="ui-corner-all">
        <div class="ui-corner-left" style="display:table-cell; text-align:center; vertical-align:middle; min-width:350px; cursor:pointer"
             onclick="window.location='.?section=home';">
            <h2 style="margin-bottom: 0px;">{$const.name}&nbsp;{$const.major}{$const.minor}</h2>
            <p style="font-size:9pt; font-style:italic;">&quot;Walking on water and developing software from a specification are easy if both are
                frozen&quot;</p>
        </div>
        <div class="ui-corner-right" style="border-left:1px solid #ccc; display:table-cell; padding:10px; width:100%;">
            {include file="sections.tpl"}
        </div>
    </div>
    <div id="pagecontainer" class="ui-corner-all"
         style="border: 1px solid #ccc; border-left:dashed 1px #ccc; border-right:dashed 1px #ccc; padding: 10px">
        {include file="$page"}
    </div>
    <div align="right" style="color:#CCc; font-size:8pt;">
        {$loadTime}s&nbsp;&copy;{$const.copyright}&nbsp;{$const.developedBy}
    </div>
</div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
                $("#pagecontainer").css("display", "none").fadeIn(400);
            }
        );

        function reload(reqdata) {
            reloadUrl("old.php", reqdata);

        }

        function reloadUrl(url, reqdata) {
            $.get(url, reqdata, function (data) {
                    $("#pagecontainer").html(data).fadeIn(200);
                }
            );
        }
    </script>
{/literal}
</body>
</html>
