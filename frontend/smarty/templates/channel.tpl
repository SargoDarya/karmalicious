{include file="header.tpl" title="Levels"}
<a href="index.php">&raquo; back to overview</a>
<h1>Karmalicious Overview for Channel {$channelName}</h1>
Currently there are <strong>{$userCount}</strong> users who gave or received Karma in this channel.<br />
<br />

<table>
    <tr>
        <th></th>
		<th colspan="2">Received</th>
        <th colspan="2">Given</th>
    </tr>
    <tr>
        <th>Username</th>
		<th>++</th>
        <th>--</th>
        <th>++</th>
        <th>--</th>
    </tr>
    {section name=mysec loop=$users}
    {strip}
    <tr>
        <td><a href="details.php?id={$users[mysec].userID}">{$users[mysec].name}</a></td>
        <td class="numberCell">{$users[mysec].positiveKarmaReceived}</td>
        <td class="numberCell">{$users[mysec].negativeKarmaReceived}</td>
        <td class="numberCell">{$users[mysec].positiveKarmaGiven}</td>
        <td class="numberCell">{$users[mysec].negativeKarmaGiven}</td>
    </tr>
    {/strip}
    {/section}
</table>
<br /><br />
You can pull Karmalicious into a channel by typing <strong>/msg Karmalicious /join #channelname</strong><br /><br />

{include file="footer.tpl"}