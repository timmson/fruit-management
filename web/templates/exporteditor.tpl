{if $smarty.request.mode ne 'async'}
{if $smarty.request.week}
	{assign var=current_week value=$smarty.request.week}
{else}
	{assign var=current_week value=$smarty.now|date_format:'%W'}
{/if}
<h2>Выгрузка</h2>
<table class="container">
   <tr>
	<th style="text-align:right;">Еженедельный отчет за текущую неделю</th>
	<td style="text-align:left">
	<a href="javascript:window.location='?type=weekly_report&week={$current_week}&mode=async&oper=doc';" id="exportdoc">	 
           <img src="{$factory->img_admin_dir}exportdoc.png" alter="[exportdoc]" title="Ехпорт в DOC"/>
	</a>
	<a href="javascript:window.location='?type=weekly_report&week={$current_week}&mode=async&oper=xls';" id="exportxls">
		<img src="{$factory->img_admin_dir}exportxls.png" alter="[exportxls]" title="Ехпорт в XLS"/>
	</a>
	</td>
   </tr>
</table>
<a href="?week={$current_week-1}">Предыдущая неделя</a>
<a href="?week={$current_week+1}">Следующая неделя</a>
{/if}
<h3>Weekly IT Development activity report: week results, alarms, next week planning</h3>
<p>Reported By: {$smarty.session.user.fio} Week:&nbsp;{$smarty.request.week}</p>
<p>Last update:&nbsp;{$smarty.request.reportdate|default:$smarty.now|date_format:$const.global.dateformat}</p>
<h4>Week Results – результаты работы за неделю<h4/>
<table style="font-size:10pt; font-family: Arial;" border="1">
     <tr style="background:#eee;">
        <th>
            №	
        </th>
        <th style="width:40%;">
            Название задачи
        </th>
        <th style="width:10%;">
            % выполнения
        </th>
        <th>
            Week results - Результат выполнения
        </th>
        <th>
            Resource - Сотрудник
        </th>
    </tr>
    {assign var=cnt value=0}
    {section name=i loop=$data}
    <tr>
        <td style="text-align:center;">
	    {assign var=cnt value=$cnt+1}
	    {$cnt}
        </td>
         <td style="text-align:left;"> 
           {$data[i].fm_project_descr}.{$data[i].fm_code}.{$data[i].fm_descr}
        </td>
        <td style="text-align:center;">
	 {if $data[i].fm_state_name eq 'done'}
           	100
          {else}
		{math equation="(a/p)*100" a=$data[i].fm_all_hour p=$data[i].fm_plan_hour format="%.0f"}
          {/if}
        </td>
        <td style="width:30%; text-align:left;">
          {if $data[i].fm_state_name ne 'in_progress'}
	   	{$data[i].fm_state}<br/>
	  {/if}
	  {if $data[i].fm_state_name ne 'done' and $data[i].fm_state_name ne 'decline' }
	  	{$data[i].fm_last_comment}<br/>
	  {/if}
        </td>
        <td style="text-align:left;"> 
           {$smarty.session.user.fio}		
        </td>
    </tr>
    {/section}
</table>
<h4>Next Week Planning – план на следующую неделю<h4/>
<table style="font-size:10pt; font-family: Arial;" border="1">
     <tr style="background:#eee;">
        <th>
            №	
        </th>
        <th style="width:40%;">
            Название задачи
        </th>
        <th style="width:10%;">
            % выполнения
        </th>
        <th style="width:30%;">
            Deliverable / completion criteria – результат, критерий выполнения
        </th>
        <th>
            Resource - Сотрудник
        </th>
    </tr>
   {assign var=cnt value=0}
   {section name=i loop=$plandata}
    <tr>
        <td style="text-align:center;">
            {assign var=cnt value=$cnt+1}
	    {$cnt}
        </td>
         <td style="text-align:left;"> 
          {$plandata[i].fm_project_descr}.{$plandata[i].fm_code}.{$plandata[i].fm_descr}
        </td>
        <td style="text-align:center;"> 
	   {if $plandata[i].fm_plan_hour ne 0}
           	{math equation="(a/p)*100" a=$plandata[i].fm_all_hour p=$plandata[i].fm_plan_hour format="%.0f"}
	   {else}
		0
	   {/if}
        </td>
        <td style="width:30%; text-align:left;">
	{$plandata[i].fm_last_comment}
  	  {if $plandata[i].fm_last_comment eq null}
		{$plandata[i].fm_state}
	  {/if}
        </td>
        <td style="text-align:left;">
	   {$smarty.session.user.fio}
        </td>
    </tr>
    {/section}
</table>
<h4>Unexecuted Week Results – задачи, которые не выполнялись<h4/>
<table style="font-size:10pt; font-family: Arial;" border="1">
     <tr style="background:#eee;">
        <th>
            №	
        </th>
        <th style="width:40%;">
            Название задачи
        </th>
        <th style="width:10%;">
            % выполнения
        </th>
        <th style="width:30%;">
            Deliverable / completion criteria – результат, критерий выполнения
        </th>
        <th>
            Resource - Сотрудник
        </th>
    </tr>
   {assign var=cnt value=0}
   {section name=i loop=$undata}
    <tr>
        <td style="text-align:center;">
            {assign var=cnt value=$cnt+1}
	    {$cnt}
        </td>
         <td style="text-align:left;"> 
          {$undata[i].fm_project_descr}.{$undata[i].fm_code}.{$undata[i].fm_descr}
        </td>
        <td style="text-align:center;">
           {if $undata[i].fm_plan_hour ne 0}
           	{math equation="(a/p)*100" a=$undata[i].fm_all_hour p=$undata[i].fm_plan_hour format="%.0f"}
	   {else}
		0
	   {/if}	
        </td>
        <td style="width:30%; text-align:left;">
	{$undata[i].fm_last_comment}
  	  {if $undata[i].fm_last_comment eq null}
		{$undata[i].fm_state}
	  {/if}
        </td>
        <td style="text-align:left;">
	   {$smarty.session.user.fio}
        </td>
    </tr>
    {/section}
</table>
