<?php /* Smarty version Smarty3rc4, created on 2011-04-19 16:41:58
         compiled from "/srv/sargodarya.de/www/karmalicious/smarty/templates/details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9965566104dad9efe3fbcb1-48200998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63d30dea936bf3e887e5b84f689d3d244caebdd8' => 
    array (
      0 => '/srv/sargodarya.de/www/karmalicious/smarty/templates/details.tpl',
      1 => 1303220516,
    ),
  ),
  'nocache_hash' => '9965566104dad9efe3fbcb1-48200998',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title',"Stats"); echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<a href="index.php">&laquo; back to overview</a>

<h1>Karmalicious Stats of <?php echo $_smarty_tpl->getVariable('user')->value;?>
</h1>

<div id="userImage" style="text-align: center;">
	<img src="image.php?user=<?php echo $_smarty_tpl->getVariable('user')->value;?>
" />
</div>

<p><?php echo $_smarty_tpl->getVariable('user')->value;?>
 currently has a Karma of <?php echo $_smarty_tpl->getVariable('karma')->value;?>
.<br />
A Karmabonus of <?php echo $_smarty_tpl->getVariable('user')->value;?>
 grants <?php echo $_smarty_tpl->getVariable('karmaPower')->value;?>
.</p>

<h3>Last 10 actions:</h3>
<?php echo $_smarty_tpl->getVariable('actions')->value;?>


<h3>Achievements:</h3>
<div id="achievements">OH MY GAWD THEY'RE COMING!!!</div>

<h2><?php echo $_smarty_tpl->getVariable('user')->value;?>
s Experience:</h2>

<div id="karmaLevelBar">
    <div id="karmaLevelProgressText"><span><?php echo $_smarty_tpl->getVariable('currentXP')->value;?>
/<?php echo $_smarty_tpl->getVariable('nextXP')->value;?>
XP</span></div>
    <div id="karmaLevelProgress" style="width: <?php echo $_smarty_tpl->getVariable('progress')->value;?>
%;"></div>
</div>

<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>