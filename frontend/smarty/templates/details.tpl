{include file="header.tpl" title="Stats"}

<a href="index.php">&laquo; back to overview</a>

<h1>Karmalicious Stats of {$user}</h1>

<div id="userImage" style="text-align: center;">
	<img src="image.php?user={$user}" />
</div>

<p>{$user} currently has a Karma of {$karma}.<br />
A Karmabonus of {$user} grants {$karmaPower}.</p>

<h3>Last 10 actions:</h3>
{$actions}

<h3>Achievements:</h3>
<div id="achievements">OH MY GAWD THEY'RE COMING!!!</div>

<h2>{$user}s Experience:</h2>

<div id="karmaLevelBar">
    <div id="karmaLevelProgressText"><span>{$currentXP}/{$nextXP}XP</span></div>
    <div id="karmaLevelProgress" style="width: {$progress}%;"></div>
</div>

{include file="footer.tpl"}