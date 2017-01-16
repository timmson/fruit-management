{if $task.tm_priority_name eq 'high'}
	{assign var="color" value="#f99"}
{elseif $task.tm_priority_name eq 'medium'}
	{assign var="color" value="#ff9"}
{else}
	{assign var="color" value="#9f9"}
{/if}
<div id="{$task.id}" class="ui-widget-content ui-corner-all draggable" style="margin-bottom: 5px; min-height:125px; padding: 2px; cursor:pointer; background:{$color};">
	<div class="ui-widget-header ui-corner-all">
		<img src="{$factory->img_admin_dir}priority_{$task.tm_priority_name}.gif" alt="{$task.tm_priority_name}" title="{$task.tm_priority_descr}"/>
		{$task.tm_name}
	</div>
	<p style="text-align:left; font-size:8pt;">
		{$task.tm_code}.{$task.tm_descr}
	</p>
	<p style="text-align:left; font-size:8pt;">
		<img id="tm_state" src="{$factory->img_admin_dir}state_{$task.tm_state_name}.gif" alt="{$task.tm_state_name}" title="{$task.tm_state}"/>
		&nbsp; 
		{$task.tm_last_comment}
	</p> 
	<p style="text-align:left; font-size:8pt;">{$task.tm_user}&nbsp;&nbsp;&nbsp;
	{if $task.tm_all_hour > $task.tm_plan_hour} 
		<span style="color:#00f; font-weight:bold;">перерасход {$task.tm_all_hour-$task.tm_plan_hour}ч</span>
	{else}
		{if $task.tm_state_name ne 'done'} 
			{$task.tm_plan_hour-$task.tm_all_hour}ч осталось
		{/if}
	{/if}
	</p>
</div>

