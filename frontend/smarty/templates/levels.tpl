{include file="header.tpl" title="Levels"}
<a href="index.php">&raquo; back to overview</a>
<h1>Karmalicious Levels</h1>
Currently there are <strong>{$levelcount} levels</strong>.<br /><br />
Only as a reference, the current positive Karma amount given is <strong>{$karmaamount}</strong><br />
which means the current overall community level is <strong>{$communityLevel}</strong><br /><br />
Once a community level milestone is reached, something special will happen.<br />
As you might have guessed, milestones are marked with the gold colored gradient.<br />
<br />

<table>
    <tr>
        <th>Level</th>
		<th>Total Experience</th>
		<th>Needed Experience</th>
    </tr>
    {section name=mysec loop=$levels}
    {strip}
    <tr class="milestone{$levels[mysec].milestone}">
        <td class="numberCell">{$levels[mysec].level}</td>
        <td class="numberCell">{$levels[mysec].experience} EXP</td>
        <td class="numberCell">+{$levels[mysec].needed} EXP</td>
    </tr>
    {/strip}
    {/section}
</table>
<br /><br />
You can pull Karmalicious into a channel by typing <strong>/msg Karmalicious /join #channelname</strong><br /><br />

{include file="footer.tpl"}