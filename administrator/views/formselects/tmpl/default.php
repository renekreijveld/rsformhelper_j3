<?php
/**
 * @version     1.0.3
 * @package     com_rsformhelper
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Rene Kreijveld <email@renekreijveld.nl> - http://www.renekreijveld.nl
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Version
$version = "1.0.3";

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_rsformhelper/assets/css/rsformhelper.css');
$document->addScript('components/com_rsformhelper/assets/js/run_prettify.js');

$user = JFactory::getUser();
$userId	= $user->get('id');
$input = JFactory::getApplication()->input;
$task = $input->post->get('task');
$formid = $input->post->get('formid');
$tablecss = $input->post->get('tablecss','','HTML');
if ($tablecss!='') $tablecss = " style=\"$tablecss\"";
$tdstylec = $input->post->get('tdstylec','','HTML');
if ($tdstylec!='') $tdstylec = " style=\"$tdstylec\"";
$tdstylev = $input->post->get('tdstylev','','HTML');
if ($tdstylev!='') $tdstylev = " style=\"$tdstylev\"";
?>
<form action="<?php echo JRoute::_('index.php?option=com_rsformhelper&view=formselects'); ?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">
	<div id="j-sidebar-container" class="span2">
	</div>
	<div id="j-main-container" class="span7">
		<?php if ($task=="process") {?>
		<h2>Here is your code!</h2>
		<?php if ($formid == "-1") {?>
			<div class="alert alert-error"><strong>Whoops</strong> you forgot to choose a form ... Please retry!</div>
		<?php } else { ?>
			<a class="btn btn-success" href="index.php?option=com_rsformhelper&view=formselects">Restart</a>&nbsp;<a class="btn" href="index.php?option=com_rsform&view=forms">Take me to RSForm!Pro</a>
			<h3>Table with all form fields:</h3>
			<?php
			echo '<pre class="prettyprint lang-html" style="padding:10px;">';
			echo htmlspecialchars('<table'.$tablecss.'>').'<br/>'.htmlspecialchars('  <tbody>').'<br/>';
			foreach ($this->items as $i => $item) :
				echo htmlspecialchars('    ');
				echo htmlspecialchars('<tr>').'<br/>';
				echo htmlspecialchars('      ');
				echo htmlspecialchars('<td'.$tdstylec.'>{'.$item->PropertyValue.':caption}</td>').'<br/>';
				echo htmlspecialchars('      ');
				echo htmlspecialchars('<td'.$tdstylev.'>{'.$item->PropertyValue.':value}</td>').'<br/>';
				echo htmlspecialchars('    ');
				echo htmlspecialchars('</tr>').'<br/>';
			endforeach;
			echo htmlspecialchars('  </tbody>').'<br/>'.htmlspecialchars('</table>').'<br/>';
			echo '</pre>';
			?>
			<h3>PHP code to add data to a database:</h3>
			<?php
			echo '<pre class="prettyprint lang-php" style="padding:10px;">';
			echo htmlspecialchars('$form = JFactory::getApplication()->input->get(\'form\', \'\', \'array\');').'<br/>';
			foreach ($this->items as $i => $item) :
				echo htmlspecialchars('$'.str_replace(' ', '_', strtolower($item->PropertyValue)).' = $form[\''.$item->PropertyValue.'\']');
				if ($item->ComponentTypeName=='selectList') echo '[0]';
				echo htmlspecialchars(';').'<br/>';
			endforeach;
			echo htmlspecialchars('$db = JFactory::getDbo();').'<br/>';
			echo htmlspecialchars('$query = $db->getQuery(true);').'<br/>';
			echo htmlspecialchars('$columns = array(\'id\'');
			foreach ($this->items as $i => $item) :
				echo htmlspecialchars(', \''.str_replace(' ', '_', strtolower($item->PropertyValue)).'\'');
			endforeach;
			echo htmlspecialchars(');').'<br/>';
			echo htmlspecialchars('$values = array(\'NULL\'');
			foreach ($this->items as $i => $item) :
				echo htmlspecialchars(', $db->quote($'.str_replace(' ', '_', strtolower($item->PropertyValue)).')');
			endforeach;
			echo htmlspecialchars(');').'<br/>';
			echo htmlspecialchars('$query').'<br/>';
			echo htmlspecialchars('  ->insert($db->quoteName(\'#__yourtable\'))').'<br/>';
			echo htmlspecialchars('  ->columns($db->quoteName($columns))').'<br/>';
			echo htmlspecialchars('  ->values(implode(\',\', $values));').'<br/>';
			echo htmlspecialchars('$db->setQuery($query);').'<br/>';
			echo htmlspecialchars('$db->execute();').'<br/>';
			echo htmlspecialchars('if ($db->getErrorMsg())').'<br/>';
			echo htmlspecialchars('{').'<br/>';
			echo htmlspecialchars('  jexit(\'Error: \'.($db->getErrorMsg()));').'<br/>';
			echo htmlspecialchars('}').'<br/>';
			echo '</pre>';
			?>
			<h3>PHP code to modify data in the database:</h3>
			<?php
			echo '<pre class="prettyprint lang-php" style="padding:10px;">';
			echo htmlspecialchars('$form = JFactory::getApplication()->input->get(\'form\', \'\', \'array\');').'<br/>';
			foreach ($this->items as $i => $item) :
				echo htmlspecialchars('$'.str_replace(' ', '_', strtolower($item->PropertyValue)).' = $form[\''.$item->PropertyValue.'\']');
				if ($item->ComponentTypeName=='selectList') echo '[0]';
				echo htmlspecialchars(';').'<br/>';
			endforeach;
			echo htmlspecialchars('$db = JFactory::getDbo();').'<br/>';
			echo htmlspecialchars('$query = $db->getQuery(true);').'<br/>';
			echo htmlspecialchars('$fields = array(').'<br/>';
			$done=0;
			$fields=count($this->items);
			foreach ($this->items as $i => $item) :
				$done++;
				echo htmlspecialchars('  $db->quoteName(\''.str_replace(' ', '_', strtolower($item->PropertyValue)).'\') . \'=\' . $db->quote($'.str_replace(' ', '_', strtolower($item->PropertyValue)).')');
				if ($done<$fields) echo ',';
				echo '<br/>';
			endforeach;
			echo htmlspecialchars(');').'<br/>';
			echo htmlspecialchars('$conditions = array(').'<br/>';
			echo htmlspecialchars('  $db->quoteName(\'id\') . \'=$your_id\'').'<br/>';
			echo htmlspecialchars(');').'<br/>';
			echo htmlspecialchars('$query').'<br/>';
			echo htmlspecialchars('  ->update($db->quoteName(\'#__yourtable\'))').'<br/>';
			echo htmlspecialchars('  ->set($fields)').'<br/>';
			echo htmlspecialchars('  ->where($conditions);').'<br/>';
			echo htmlspecialchars('$db->setQuery($query);').'<br/>';
			echo htmlspecialchars('$db->execute();').'<br/>';
			echo htmlspecialchars('if ($db->getErrorMsg())').'<br/>';
			echo htmlspecialchars('{').'<br/>';
			echo htmlspecialchars('  jexit(\'Error: \'.($db->getErrorMsg()));').'<br/>';
			echo htmlspecialchars('}').'<br/>';
			echo '</pre>';
			?>
		<?php } ?>
		<a class="btn btn-success" href="index.php?option=com_rsformhelper&view=formselects">Restart</a>&nbsp;<a class="btn" href="index.php?option=com_rsform&view=forms">Take me to RSForm!Pro</a>
		<?php } else {?>
		<h1>Welcome to RSForm! Helper</h1>
		<h2>Choose your form and settings:</h2>
		<div class="control-group">
			<label class="control-label">Form</label>
			<div class="controls">
				<select class="input-xlarge" name="formid" id="formid">
					<option value="-1">--- Choose Form ---</option>
					<?php foreach ($this->items as $i => $item) :?>
					<option value="<?php echo $item->FormId;?>"><?php echo $item->FormName;?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="control-group tdcsscaption">
			<label class="control-label">
				<a class="hasTooltip nolink" title="CSS code to be applied to the column that displays the form field <em>caption</em>." data-toggle="tooltip" href="#">TD css caption <span class="icon-info"></span></a><br/>
			</label>
			<div class="controls">
				<input name="tdstylec" type="text" id="tdstylec" class="input-xlarge" value=""><br/>
				<em>Example:</em> <strong>width:200px;font-weight:bold;</strong>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">
				<a class="hasTooltip nolink" title="CSS code to be applied to the column that displays the form field <em>value</em>." data-toggle="tooltip" href="#">TD css value <span class="icon-info"></span></a><br/>
			</label>
			<div class="controls">
				<input name="tdstylev" type="text" id="tdstylev" class="input-xlarge" value=""><br/>
				<em>Example:</em> <strong>width:400px;font-size:12px;</strong>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">
				<a class="hasTooltip nolink" title="CSS code to be applied to the whole table." data-toggle="tooltip" href="#">Full table CSS <span class="icon-info"></span></a><br/>
			</label>
			<div class="controls">
				<input name="tablecss" type="text" class="input-xlarge" id="tablecss" value=""><br/>
				<em>Example:</em> <strong>width:600px;border-collapse:collapse;</strong>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-success">Generate code</button>
			</div>
		</div>
		<input name="task" type="hidden" value="process">
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
		<?php } ?>
		<hr>
		<p align="center">RSForm! Helper, created by <a target="_blank" href="http://about.me/renekreijveld">René Kreijveld</a>, (C) <?php echo date("Y");?>.</p>
	</div>
	<div class="span3">
		<?php if ($task=="") {?>
		<h2>How this works</h2>
		<p>RSForm! Helper asks you to choose one of your existing RSForm!Pro forms.</p>
		<p>Additionally you can optionally enter some CSS styling that will be applied to the Caption column, Value column or the whole <?php echo htmlspecialchars('<table>');?>.</p>
		<p>RSForm! Helper then generates HTML code that you can use in the User Emails and Admin Emails of your form.</p>
		<p>RSForm! Helper also generaties PHP code that can be usefull in the PHP Scripts of your form.</p>
		<p>RSForm! Helper was written by René Kreijveld and is provided free of charge, without warranties. Questions, remarks, improvements? Feel free to <a target="_blank" href="http://about.me/renekreijveld">contact me</a>.</p>
		<p>Version: <?php echo $version;?></p>
		<p>RSForm! Helper on github: <a target="_blank" href="https://github.com/renekreijveld/rsformhelper_j3">https://github.com/renekreijveld/rsformhelper_j3</a></p>
		<?php }?>
	</div>
</form>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery.fn.prettify = function () { this.html(prettyPrintOne(this.html())); };
		jQuery('.prettyprint').prettify();
		jQuery("[rel=popover]").popover();
	});
</script>