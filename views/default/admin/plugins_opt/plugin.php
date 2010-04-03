<?php
/**
 * Elgg plugin manifest class
 *
 * This file renders a plugin for the admin screen, including active/deactive, manifest details & display plugin
 * settings.
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

$plugin = $vars['plugin'];
$details = $vars['details'];

$active = $details['active'];
$manifest = $details['manifest'];

// Check elgg version if available
$version_check_valid = false;
if ($manifest['elgg_version']) {
	$version_check_valid = check_plugin_compatibility($manifest['elgg_version']);
}

$ts = time();
$token = generate_action_token($ts);
?>
<div class="plugin_details <?php if ($active) echo "active"; else echo "not_active" ?>">
	<div class="admin_plugin_reorder">
<?php
			if ($vars['order'] > 10) {
				$top_url = "{$vars['url']}action/admin/plugins/reorder?plugin={$plugin}&order=1&__elgg_token=$token&__elgg_ts=$ts";
				$order = $vars['order'] - 11;
				$up_url = "{$vars['url']}action/admin/plugins/reorder?plugin={$plugin}&order=$order&__elgg_token=$token&__elgg_ts=$ts";
?>
			<a href="<?php echo elgg_format_url($top_url); ?>"><?php echo elgg_echo("top"); ?></a>
			<a href="<?php echo elgg_format_url($up_url); ?>"><?php echo elgg_echo("up"); ?></a>
<?php
			}
		?>
		<?php
			if ($vars['order'] < $vars['maxorder']) {
				$order =  $vars['order'] + 11;
				$down_url = "{$vars['url']}action/admin/plugins/reorder?plugin={$plugin}&order=$order&__elgg_token=$token&__elgg_ts=$ts";
				$order = $vars['maxorder'] + 11;
				$bottom_url = "{$vars['url']}action/admin/plugins/reorder?plugin={$plugin}&order=$order&__elgg_token=$token&__elgg_ts=$ts";
?>
			<a href="<?php echo elgg_format_url($down_url); ?>"><?php echo elgg_echo("down"); ?></a>
			<a href="<?php echo elgg_format_url($bottom_url); ?>"><?php echo elgg_echo("bottom"); ?></a>
<?php
			}
		?>
	</div><div class="clearfloat"></div>
	<div class="admin_plugin_enable_disable">
		<?php if ($active) {
			$url = "{$vars['url']}action/admin/plugins/disable?plugin=$plugin&__elgg_token=$token&__elgg_ts=$ts";
		?>
			<a class="cancel_button" href="<?php echo elgg_format_url($url); ?>"><?php echo elgg_echo("disable"); ?></a>
		<?php } else { 
			$url = "{$vars['url']}action/admin/plugins/enable?plugin=$plugin&__elgg_token=$token&__elgg_ts=$ts";
		?>
			<a class="submit_button" href="<?php echo elgg_format_url($url); ?>"><?php echo elgg_echo("enable"); ?></a>
		<?php } ?>
	</div>

	<h3><?php echo $plugin; ?><?php if (elgg_view("settings/{$plugin}/edit")) { ?> <a class="plugin_settings small link" onclick="elgg_slide_toggle(this,'.plugin_details','.pluginsettings');">[<?php echo elgg_echo('settings'); ?>]</a><?php } ?></h3>

	<?php if (elgg_view("settings/{$plugin}/edit")) { ?>
	<div class="pluginsettings hidden">
			<div id="<?php echo $plugin; ?>_settings">
				<?php echo elgg_view("object/plugin", array('plugin' => $plugin, 'entity' => find_plugin_settings($plugin))) ?>
			</div>
	</div>
	<?php } ?>

	<?php

		if ($manifest) {

	?>
		<div class="plugin_description"><?php echo elgg_view('output/longtext',array('value' => $manifest['description'])); ?></div>
	<?php

		}

	?>

	<p><a class="manifest_details small link" onclick="elgg_slide_toggle(this,'.plugin_details','.manifest_file');"><?php echo elgg_echo("admin:plugins:label:moreinfo"); ?></a></p>

	<div class="manifest_file hidden">

	<?php if ($manifest) { ?>
		<?php if ((!$version_check_valid) || (!isset($manifest['elgg_version']))) { ?>
		<div id="version_check">
			<?php
				if (!isset($manifest['elgg_version']))
					echo elgg_echo('admin:plugins:warning:elggversionunknown');
				else
					echo elgg_echo('admin:plugins:warning:elggtoolow');
			?>
		</div>
		<?php } ?>
		<div><?php echo elgg_echo('admin:plugins:label:version') . ": ". htmlspecialchars($manifest['version']) ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:author') . ": ". htmlspecialchars($manifest['author']) ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:copyright') . ": ". htmlspecialchars($manifest['copyright']) ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:licence') . ": ". htmlspecialchars($manifest['licence'] . $manifest['license']) ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:website') . ": "; ?><a href="<?php echo $manifest['website']; ?>"><?php echo $manifest['website']; ?></a></div>
	<?php } ?>

	</div>

</div>