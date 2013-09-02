<?php /* Smarty version Smarty3rc4, created on 2011-03-03 17:57:06
         compiled from "/srv/sargodarya.de/www/karmalicious/smarty/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7627621734d6fc862008996-27996069%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0449eaba27ae0087986711f7bf20683ac7c6995' => 
    array (
      0 => '/srv/sargodarya.de/www/karmalicious/smarty/templates/index.tpl',
      1 => 1299171421,
    ),
  ),
  'nocache_hash' => '7627621734d6fc862008996-27996069',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title',"Stats"); echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<h1>Karmalicious Stats</h1>
Currently there are <strong><?php echo $_smarty_tpl->getVariable('usercount')->value;?>
 users</strong> which have received or given Karma.<br />
<br />
There's a total of <strong><?php echo $_smarty_tpl->getVariable('karmacount')->value;?>
 Karma granted</strong> where <strong style="color: green"><?php echo $_smarty_tpl->getVariable('positivekarma')->value;?>
 positive</strong> and <strong style="color: red"><?php echo $_smarty_tpl->getVariable('negativekarma')->value;?>
 negative</strong> Karma was given.<br />
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
    <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['name'] = 'mysec';
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('topusers')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['total']);
?>
    <tr><td class="numberCell">#<?php echo $_smarty_tpl->getVariable('topusers')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['rank'];?>
</td><td><a href="details.php?id=<?php echo $_smarty_tpl->getVariable('topusers')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['id'];?>
"><?php echo $_smarty_tpl->getVariable('topusers')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['username'];?>
</a></td><td class="numberCell"><?php echo $_smarty_tpl->getVariable('topusers')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['karmasum'];?>
</td><td class="numberCell"><?php echo $_smarty_tpl->getVariable('topusers')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['karmapower'];?>
</td><td class="numberCell"><?php echo $_smarty_tpl->getVariable('topusers')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['level'];?>
</td></tr>
    <?php endfor; endif; ?>
</table>
<br /><br />
Karmalicious currently can be found in the <strong>following channels</strong>: <br />
<?php echo $_smarty_tpl->getVariable('channels')->value;?>
<br />
<br />
You can pull Karmalicious into a channel by typing <strong>/msg Karmalicious /join #channelname</strong><br /><br />

<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>