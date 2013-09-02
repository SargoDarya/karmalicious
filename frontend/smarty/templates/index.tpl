{include file="header.tpl" title="Stats"}

<h1>Karmalicious Stats</h1>
Currently there are <strong>{$usercount} users</strong> which have received or given Karma.<br />
<br />
There's a total of <strong>{$karmacount} Karma granted</strong> where <strong style="color: green">{$positivekarma} positive</strong> and <strong style="color: red">{$negativekarma} negative</strong> Karma was given.<br />
<br />
<a href="channels.php">Channels</a> | <a href="levels.php">Levels</a><br />
<br />

<table>
    <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Current Karma</th>
        <th>Karma Power</th>
        <th>Level</th>
    </tr>
    {section name=mysec loop=$topusers}
    {strip}
    <tr>
        <td class="numberCell">#{$topusers[mysec].rank}</td>
        <td><a href="details.php?id={$topusers[mysec].id}">{$topusers[mysec].username}</a></td>
        <td class="numberCell">{$topusers[mysec].karmasum}</td>
        <td class="numberCell">{$topusers[mysec].karmapower}</td>
        <td class="numberCell">{$topusers[mysec].level}</td>
    </tr>
    {/strip}
    {/section}
</table>
<br /><br />
Karmalicious currently can be found in the <strong>following channels</strong>: <br />
{$channels}<br />
<br />
You can pull Karmalicious into a channel by typing <strong>/msg Karmalicious /join #channelname</strong><br /><br />

{include file="footer.tpl"}