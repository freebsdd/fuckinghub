<html>
<head>
    <meta charset="utf-8" />
    <title>{{ document.title }} - Example twig</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/templates/css/system.css">
    {% if document.place == 'products' %}
    <link rel="stylesheet" href="/templates/css/prods.css">
    {% endif %}
</head>
<body>

<div class="wrapper">
    <div class="content">
        <header>
            <img src="/img/system/logo.gif" style="float: left; max-width: 50px; margin: 10px 0 0 10px;">
            <div style="float: left; margin: 15px 0 0 10px;">Магазин спецодежды</div>
        </header>
        <div class="menu">
            <ul>
                <li><a href="/" title="">Главная</a></li>
                <li><a href="/?tovary" title="">Товары</a></li>
                <li><a href="/?kontakty" title="">Контакты</a></li>
            </ul>
        </div>
        <h1>{{ document.h1 }}</h1>
        {{ document.content }}
    </div>
</div>
<footer><div class="copyright">© Copyright by Eddie</div></footer>
<script src="/templates/js/jquery-1.12.4.min.js"></script>
<script src="/templates/js/common.js"></script>
{% if document.place == 'products' %}
<script src="/templates/js/products.js"></script>
{% endif %}
</body>
</html>