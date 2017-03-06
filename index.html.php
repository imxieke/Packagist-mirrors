<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Packagist China</title>

<style>
html, button, input, select, textarea, div {
font-family:'Lucida Grande','Hiragino Kaku Gothic ProN',Meiryo,sans-serif !important;
-webkit-text-size-adjust: 100%;
text-size-adjust: 100%;
}

code {
font-family: Consolas,"Liberation Mono",Courier,monospace !important;
font-size: 16px;
line-height: 1.3;
word-wrap: break-word;
}
pre {
background-color: #3d3d5c;
padding: 0.5em;
color: white;
}
h1 {
margin:0;
    padding:0;
}
.banner {
    font-size: 300%;
    text-align: center;
}
@media screen and (min-width : 768px){
    .banner{ font-size : 500%;} 
}
 
@media screen and (min-width : 1024px) {
    .banner{ font-size : 700%;} 
}

</style>
</head>
<body>
<header>
<h3 class="banner">Packagist<span style="color:red"> </span>China</h3>
<p align="center">最后同步时间： <?= date('Y年n月j日 H:i:s') ?></p>
</header>
    
<pre><code>enable:  $ composer config -g repos.packagist composer <?= $url ?></code></pre>
<pre><code>disable: $ composer config -g --unset repos.packagist</code></pre>

<address style="text-align:center">@2017 Power By imxieke</address>
</body>
</html>
