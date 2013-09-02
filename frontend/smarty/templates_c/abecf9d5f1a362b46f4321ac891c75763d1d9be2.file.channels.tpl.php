<?php /* Smarty version Smarty3rc4, created on 2011-02-25 22:44:01
         compiled from "/srv/sargodarya.de/www/karmalicious/smarty/templates/channels.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13612096424d6822a160f518-28217023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'abecf9d5f1a362b46f4321ac891c75763d1d9be2' => 
    array (
      0 => '/srv/sargodarya.de/www/karmalicious/smarty/templates/channels.tpl',
      1 => 1298670240,
    ),
  ),
  'nocache_hash' => '13612096424d6822a160f518-28217023',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title',"Channels"); echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<a href="index.php">&raquo; back to overview</a>
<h1>Karmalicious Channels</h1>
Currently there are <strong><?php echo $_smarty_tpl->getVariable('channelCount')->value;?>
 channels</strong>.<br />
<br />

<table>
    <tr>
        <th>Channel</th>
		<th>User Count</th>
		<th>Good Karma</th>
		<th>Bad Karma</th>
		
    </tr>
    <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['name'] = 'mysec';
$_smarty_tpl->tpl_vars['smarty']->value['section']['mysec']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('channels')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <tr><td><a href="channel.php?name=<?php echo $_smarty_tpl->getVariable('channels')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['link'];?>
"><?php echo $_smarty_tpl->getVariable('channels')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['name'];?>
</a></td><td class="numberCell"><?php echo $_smarty_tpl->getVariable('channels')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['users'];?>
</td><td class="numberCell"><?php echo $_smarty_tpl->getVariable('channels')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['good'];?>
</td><td class="numberCell"><?php echo $_smarty_tpl->getVariable('channels')->value[$_smarty_tpl->getVariable('smarty')->value['section']['mysec']['index']]['bad'];?>
</td></tr>
    <?php endfor; endif; ?>
</table>
<br /><br />
You can pull Karmalicious into a channel by typing <strong>/msg Karmalicious /join #channelname</strong><br /><br />

<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>