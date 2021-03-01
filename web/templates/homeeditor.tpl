{if $smarty.request.mode ne 'async'}
<table style="font-size:8pt" class="plain" width="100%">
<tr><td style="width:45%; vertical-align:top; padding: 2px;">
<h3>Моя активность</h3>
<table width="100%" class="container">
   <tr style="font-weight:bold;">
      <th>Задача</th>
      <th>Статус</th>
      <th>ПН</th>
      <th>ВТ</th>
      <th>СР</th>
      <th>ЧТ</th>
      <th>ПТ</th>
   </tr>
   {section name=i loop=$timesheet}
	{assign var="mon" value="$mon+$timesheet[i].task_spent_mon"}
	{assign var="tue" value="$tue+$timesheet[i].task_spent_tue"}
	{assign var="wen" value="$wen+$timesheet[i].task_spent_wen"}
	{assign var="th" value="$th+$timesheet[i].task_spent_th"}
	{assign var="fr" value="$fr+$timesheet[i].task_spent_fr"}
   <tr >
   <td style="text-align:left;">
	 <a href="?dep=task&task={$timesheet[i].task_id}">
		{$timesheet[i].project_name}-{$timesheet[i].task_id}&nbsp;{$timesheet[i].task_name}.{$timesheet[i].task_descr}
	</a>
     </td>
     <td>
	<!--img src="{$factory->img_admin_dir}state_{$timesheet[i].fm_state_name}.gif" alt="{$timesheet[i].fm_state_name}" title="{$timesheet[i].fm_state}"/-->{$timesheet[i].task_state}
      </td>
	<td align="center">{$timesheet[i].task_spent_mon}</td>
	<td align="center">{$timesheet[i].task_spent_tue}</td>
	<td align="center">{$timesheet[i].task_spent_wen}</td>
	<td align="center">{$timesheet[i].task_spent_th}</td>
	<td align="center">{$timesheet[i].task_spent_fr}</td>
   </tr>
   {/section}
   <tr style="font-weight:bold;">
      <td colspan="2" style="text-align:right">
		{if $fr eq 8}
			<span style="text-decoration:blink; color:red;">ОТЧЕТ!!!</span>
		{else}
			Итого
		{/if}
	</td>
	<td align="center">{$mon}</td>
	<td align="center">{$tue}</td>
	<td align="center">{$wen}</td>
	<td align="center">{$th}</td>
	<td align="center">{$fr}</td>
   </tr>
</table>
<h3>Мои подписки</h3>
<table class="container" width="100%">
   <tr style="font-weight:bold">
      <td>Задача</td>
      <td>Пользователь</td>
      <td>%</td>
      <td>Статус</td>
   </tr>
    {section name=i loop=$subcribe_tasks}
   <tr>
      <td style="text-align:left;">
	  <a href="?dep=task&task={$subcribe_tasks[i].id}">
		{$subcribe_tasks[i].fm_name}&nbsp;{$subcribe_tasks[i].fm_code}.{$subcribe_tasks[i].fm_descr}
	  </a>
      </td>
      <td style="text-align:left;">{$subcribe_tasks[i].fm_user}</td>
      <td>
	 	{math equation="(a/p)*100" a=$subcribe_tasks[i].fm_all_hour p=$subcribe_tasks[i].fm_plan_hour format="%.0f"}
      </td>
      <td>
	<img src="{$factory->img_admin_dir}state_{$subcribe_tasks[i].fm_state_name}.gif" alt="{$subcribe_tasks[i].fm_state_name}" title="{$subcribe_tasks[i].fm_state}"/>
       </td>
   </tr>
   {/section}
</table>   
</td><td style="vertical-align:top; padding: 2px;">
<h3>Мои задачи</h3>
<table class="container" width="100%">
   <tr style="font-weight:bold">
      <td>Задача</td>
      <td>Состояние</td>
      <td>%</td>
      <td>Приоритет</td>
      <td>Статус</td>
   </tr>
    {section name=i loop=$tasks}
   <tr>
      <td style="text-align:left;">
	  <a href="?dep=task&task={$tasks[i].id}">
		{$tasks[i].fm_name}&nbsp;{$tasks[i].fm_code}.{$tasks[i].fm_descr}
	  </a>
      </td>
      <td style="text-align:left;">{$tasks[i].fm_last_comment}</td>
      <td>
	 {math equation="(a/p)*100" a=$tasks[i].fm_all_hour p=$tasks[i].fm_plan_hour format="%.0f"}
      </td>
      <td>
	   <img src="{$factory->img_admin_dir}priority_{$tasks[i].fm_priority_name}.gif" alt="{$tasks[i].fm_priority_name}" title="{$tasks[i].fm_priority_descr}"/>
	</td>
      <td>
	<img src="{$factory->img_admin_dir}state_{$tasks[i].fm_state_name}.gif" alt="{$tasks[i].fm_state_name}" title="{$tasks[i].fm_state}"/>
        </td>
   </tr>
   {/section}
</table>
</td></tr></table>
<h3>Календарное планирование</h3>
<table class="container" width="100%" style="font-size:8pt">
   <tr>
      <th rowspan="2">Задача</th>
      <th rowspan="2">Длина</th>
       <th colspan="{$monthcal|@count}">
			{$smarty.now|date_format:"%m.%Y"}
       </th>
   </tr>
   <tr>
      {section name=m loop=$monthcal}
       <th width="15px;" {if $monthcal[m].isweekend}style="color:#f66;"{/if}>
       		{$monthcal[m].day}
       </th>
      {/section}
   </tr>
    {section name=i loop=$plantasks}
   <tr>
      <td style="text-align:left;">
	  <a href="?dep=task&task={$plantasks[i].id}">
		{$plantasks[i].fm_name}&nbsp;{$plantasks[i].fm_code}.{$plantasks[i].fm_descr}
	  </a>
      </td>
      <td>
      	  {math equation="floor((p-r)/8)" r=$plantasks[i].fm_all_hour p=$plantasks[i].fm_plan_hour format="%.0f"}д
      	  {math equation="(p-r)%8" r=$plantasks[i].fm_all_hour p=$plantasks[i].fm_plan_hour format="%.0f"}ч
      </td>
       {section name=m loop=$monthcal}
   		{assign var=bgcolor value=inherit}
   		{if $monthcal[m].day >= $plantasks[i].fm_plan_start and $monthcal[m].day <= $plantasks[i].fm_plan_end}
		   		{assign var="bgcolor" value="#0f0"}
   				{if $plantasks[i].fm_priority eq 2}
   		   			{assign var="bgcolor" value="#8f8"}
   		   		{/if}
   		   		{if $plantasks[i].fm_priority eq 3}
   		   			{assign var="bgcolor" value="#dfd"}
   		   		{/if}
   		{/if}
       	<td style="background:{$bgcolor};"> 
			&nbsp;
       	</td>
       {/section}
   </tr>
   {/section}
</table>
<h3>Активность команды</h3>
<div id="activity"/>
{literal}
<script type="text/javascript">
	$(function() {
		$.get(window.location, {mode:'async'}, function(data) {
				$("div#activity").html($.trim(data));
				return;
				}	
			);
	});
</script>
{/literal}
{else}
{assign var='dow' value=$smarty.now|date_format:"%w"}
<table class="container" width="100%" style="font-size:8pt">
	{section name=i loop=$activity}
   <tr>
   	  {if $activity[i].fm_spent_hour ne 0}
   	  	{assign var='color' value='green'}
   	  {elseif $activity[i].fm_days_ago > $dow}
   	  	{assign var='color' value='#666'}
   	  {else}
   	  	{assign var='color' value='inherit'} 
   	  {/if} 
   	  <td style="text-align:left; padding: 10px; color:{$color};">
		 
   	  	 {if $activity[i].fm_days_ago eq 0}
   	  	 	Сегодня
   	  	 {elseif $activity[i].fm_days_ago eq 1}
   	  	 	Вчера
   	  	 {elseif $activity[i].fm_days_ago > $dow}
   	  	    На прошлой неделе	
         {elseif $activity[i].fm_days_ago eq 2 or $activity[i].fm_days_ago eq 3 or $activity[i].fm_days_ago eq 4}
   	  			{$activity[i].fm_days_ago}&nbsp;дня&nbsp;назад
   	  	 {else}
   	  			{$activity[i].fm_days_ago}&nbsp;дней&nbsp;назад
   	  	 {/if}
   	  	пользователь <b>{$activity[i].fm_user}</b>
   	  	{if $activity[i].fm_spent_hour ne 0}
   	  		{$activity[i].fm_spent_hour}
   	  		{if $activity[i].fm_spent_hour eq 1}
   	  			час
   	  		{elseif $activity[i].fm_spent_hour eq 2 or $activity[i].fm_spent_hour eq 3 or $activity[i].fm_spent_hour eq 4}
   	  			часа
   	  		{else}
   	  			часов
   	  		{/if}
   	  	{/if}
   	  	работал над задачей 
   	  	<a style="font-weight: bold;" href="?dep=task&task={$activity[i].fm_task}">[{$activity[i].fm_name}.{$activity[i].fm_descr}]</a>
   	  	&nbsp;-&nbsp;<i>{$activity[i].fm_comment}</i>
   	  </td>
   </tr>
   {/section}
</table>
{/if}
