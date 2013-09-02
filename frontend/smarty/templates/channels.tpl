{include file="header.tpl" title="Channels"}
<a href="index.php">&raquo; back to overview</a>
<h1>Karmalicious Channels</h1>
Currently there are <strong>{$channelCount} channels</strong>.<br />
<br />

<table>
    <tr>
        <th>Channel</th>
		<th>User Count</th>
		<th>Good Karma</th>
		<th>Bad Karma</th>
		
    </tr>
    {section name=mysec loop=$channels}
    {strip}
    <tr>
        <td><a href="channel.php?name={$channels[mysec].link}">{$channels[mysec].name}</a></td>
        <td class="numberCell">{$channels[mysec].users}</td>
		<td class="numberCell">{$channels[mysec].good}</td>
		<td class="numberCell">{$channels[mysec].bad}</td>
    </tr>
    {/strip}
    {/section}
</table>
<br /><br />
You can pull Karmalicious into a channel by typing <strong>/msg Karmalicious /join #channelname</strong><br /><br />

{include file="footer.tpl"}