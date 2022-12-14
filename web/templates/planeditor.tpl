Релизы:
{section name=i loop=$release}
	&nbsp;<a id="{$release[i].id}" href="#" class="rellink" {if $relid eq $release[i].id}style="font-weight:bold"{/if}>
		{$release[i].fm_code}.{$release[i].fm_descr}
	</a>&nbsp;
{/section}
<div style="float:right;">
	<a href="?section=agile">Гибкое&nbsp;планирование</a>
</div>

<h3>Календарное планирование</h3>
<table class="container" width="100%">
   <tr>
      <th rowspan="2">Пользователь</th>
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
      <td>
      	 <a href="?section=user&user={$plantasks[i].fm_user}">{$plantasks[i].fm_user}</a>
      </td>
      <td>
      	  {math equation="(p-r)/8" r=$plantasks[i].fm_all_hour p=$plantasks[i].fm_plan_hour format="%.0f"}д
      	  {math equation="(p-r)%8" r=$plantasks[i].fm_all_hour p=$plantasks[i].fm_plan_hour format="%.0f"}ч
      </td>
       {foreach $monthcal as $day}
   		{assign var="bgcolor" value="inherit"}
   		{if $day.day >= $plantasks[i].fm_plan_start and $day.day <= $plantasks[i].fm_plan_end}
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
       {/foreach}
   </tr>
   {/section}
</table>

<h3>Структура</h3>
<table class="container" width="100%">
   	<tr>
		<th style="width:15%;">Запрос</th>
		<th  style="width:40%;">Задача</th>
		<th>Исполнитель</th>
		<th>%</th>
		<th>Приоритет</th>
		<th>Статус</th>
	</tr>
	{assign var=plan_hour value=0}
	{assign var=all_hour value=0}
	{section name=i loop=$structtasks}
		{section name=j loop=$structtasks[i].child}
		{if $structtasks[i].child[j].fm_state_name ne 'declie' and $structtasks[i].child[j].fm_state_name ne 'done'}
			{assign var=plan_hour value=$structtasks[i].child[j].fm_plan_hour+$plan_hour}
			{assign var=all_hour value=$structtasks[i].child[j].fm_all_hour+$all_hour}
		{/if}
	<tr>
		{if $smarty.section.j.index eq 0}
    	<td style="text-align:left; vertical-align:top;" rowspan="{math equation="x" x=$structtasks[i].child|@count}">			
			<a href="?section=task&task={$structtasks[i].id}" style="font-size:8pt">
				{$structtasks[i].fm_name}&nbsp;{$structtasks[i].fm_code}.{$structtasks[i].fm_descr}
			</a>
    	</td>
		{/if}
        <td style="text-align:left;">
	 	     <a href="?section=task&task={$structtasks[i].child[j].id}" style="font-size:8pt">
	 	     	{$structtasks[i].child[j].fm_name}&nbsp;{$structtasks[i].child[j].fm_code}.{$structtasks[i].child[j].fm_descr}
	 	     </a>
		</td>
		<td >
	 	     <a href="?section=user&user={$structtasks[i].child[j].fm_user}">{$structtasks[i].child[j].fm_user}</a>
		</td>
		<td>
           {if $structtasks[i].child[j].fm_plan_hour ne 0}
		 	   {if $structtasks[i].child[j].fm_state_name eq 'done'}
		       		  100
				{else}
			  		  {math equation="(a/p)*100" a=$structtasks[i].child[j].fm_all_hour p=$structtasks[i].child[j].fm_plan_hour format="%.0f"}
		      	{/if}
		   {else}
		   		N/A
		   {/if} 
		</td>
		 <td>
	 	    <img src="{$factory->img_admin_dir}priority_{$structtasks[i].child[j].fm_priority_name}.gif" alt="{$structtasks[i].child[j].fm_priority_name}" title="{$task.fm_priority_descr}"/>
    	  </td>
		<td >
	 	     <img src="{$factory->img_admin_dir}state_{$structtasks[i].child[j].fm_state_name}.gif" alt="{$structtasks[i].child[j].fm_state_name}" title="{$structtasks[i].child[j].fm_state}"/>
		</td>
    </tr>
    {sectionelse}
	<tr>
		<td style="width:30%; text-align:left;">
			<a href="?section=task&task={$structtasks[i].id}" style="font-size:8pt">
				{$structtasks[i].fm_name}&nbsp;{$structtasks[i].fm_code}.{$structtasks[i].fm_descr}
			</a>
		</td>
		<td colspan="6">&nbsp;</td>
	</tr>
	   {/section}
   {/section}
</table>
{literal}
<script type="text/javascript">
	$(function() {
		
		$(".rellink").click(function() {
			var reqdata = {
					'mode':'async', 
					'release': $(this).prop("id")
					};
		
			reload(reqdata);
		});

	});
</script>
{/literal}

