<?php  
	$file = './php/First.txt';
	$content = file_get_contents($file);
	if($content == 0){
		file_put_contents($file,'1');
		require_once './php/init.php';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="基于vuejs搭建的房产信息网站">
    <meta name="author" content="Jer">
    <meta name="Keywords" content="房产信息,vuejs,mdl">

	<link rel="stylesheet" href="./css/material.min.css">
	<script src="./js/material.min.js"></script>
	<link rel="stylesheet" href="./css/icon.css">
	<script type="text/javascript" src="./js/vue.js"></script>
	<script type="text/javascript" src="./js/vue-resource.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/Realty.css">

</head>
<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs" id="xjw">
		<header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
				<!-- Title -->
				<span v-if="!isAdmin" class="mdl-layout-title">随缘吧</span>
				<span v-else class="mdl-layout-title">{{user.name}}</span>
				<div class="mdl-layout-spacer"></div>
				<!-- Search -->
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
				mdl-textfield--floating-label mdl-textfield--align-right">
					<label class="mdl-button mdl-js-button mdl-button--icon"
					for="waterfall-exp">
						<i class="material-icons">search</i>
					</label>
					<div class="mdl-textfield__expandable-holder">
						<input @keyup.enter = "icon_search" v-model="iS_text" class="mdl-textfield__input" type="text" name="sample"
						id="waterfall-exp" placeholder="Want to search what?">
					</div>
					<button id="menu1" class="mdl-button mdl-js-button mdl-button--icon">
					  <i class="material-icons">add</i>
					</button>
					<ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right mdl-js-ripple-effect" for="menu1">
						<li class="mdl-menu__item">Login in</li>
						<li id="show-dialog" class="mdl-menu__item">Sign up</li>
					</ul>
				</div>
				<!-- button -->
			</div>
			<!-- Tabs -->
			<div class="mdl-layout__tab-bar mdl-js-ripple-effect">
				<a href="#fixed-tab-1" class="mdl-layout__tab is-active">搜索界面</a>
				<a href="#fixed-tab-2" class="mdl-layout__tab">展示界面</a>
				<a href="#fixed-tab-3" class="mdl-layout__tab">信息界面</a>
				<a href="#fixed-tab-4" class="mdl-layout__tab">个人中心</a>
			</div>
		</header>
		<div class="mdl-layout__drawer">
			<span class="mdl-layout-title">随缘吧</span>
			<nav class="mdl-navigation">
				<a class="mdl-navigation__link">这里并没有什么用</a>
			</nav>
		</div>
		<main class="mdl-layout__content">
			<section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
				<div class="page-content mdl-grid">
					<x-search v-ref:i-search></x-search>
				</div>
			</section>
			<section class="mdl-layout__tab-panel" id="fixed-tab-2">
				<div class="page-content mdl-grid">
					<x-list v-ref:i-list></x-list>
				</div>
			</section>
			<section class="mdl-layout__tab-panel" id="fixed-tab-3">
				<div class="page-content mdl-grid">
					<!-- Tabs -->
					<x-card></x-card>
					<!-- Tabs End -->
				</div>
			</section>
			<section class="mdl-layout__tab-panel" id="fixed-tab-4">
				<div class="page-content mdl-grid">
					<x-login></x-login>
				</div>
			</section>
		</main>
	</div>
	<script type="text/javascript" src="./js/search.js"></script>
	<script type="text/javascript" src="./js/login.js"></script>
	<script type="text/javascript" src="./js/list.js"></script>
	<script type="text/javascript" src="./js/card.js"></script>
	<script type="text/javascript" src="./js/root.js"></script>
</body>
</html>