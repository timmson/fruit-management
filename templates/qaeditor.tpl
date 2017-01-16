{assign var=projectid value=0}
{if $smarty.request.project ne null}
	{assign var=projectid value=$smarty.request.project}
{/if}
Проект:
{section name=i loop=$projects}
	{assign var=index value=$smarty.section.i.index}
	&nbsp;<a id="{$index}" href="#" class="projectlink" {if $projectid eq $index}style="font-weight:bold"{/if}>
		 {$projects[i].name}
	</a>&nbsp;
{/section}
<div id="tabs">
	<ul>
		<li><a href="#defectTab">Дефекты</a></li>
		<li><a href="#buildTab">Сборки</a></li>
	</ul>
<div id="defectTab">
<table class="container" style="font-size:8pt;">
	<tr>
		<th>Номер</th>
		<th>Дата</th>
		<th>Название</th>
		<th>Важность</th>
		<th>Пользователь</th>
		<th>&nbsp;</th>
	</tr>
	{section name=i loop=$defects}
	<tr>
		<td>Defect#{$defects[i].id}</a></td>
		<td>{$defects[i].lastModified|date_format:$const.global.dateformat}</td>
		<td style="text-align:left; padding-left: 5px;">{$defects[i].name}</td>
		<td>
			<img src="{$factory->img_admin_dir}priority_{$defects[i].priority}.gif" alt="{$defects[i].severity}" title="{$defects[i].severity}"/>
		</td>
		<td>{$defects[i].owner}</td>
		<td>
			<a href="?dep=task&task=0&oper=new&tm_name=Defect%23{$defects[i].id}&tm_descr={$defects[i].name|escape}&tm_project={$projects[$projectid].fm}" title="Создать&nbsp;задачу&nbsp;на&nbsp;основе&nbsp;дефекта">
				<img src="{$factory->img_admin_dir}copy.png"/>
			</a>
		</td>
	</tr>
	{/section}
</table>
</div>
<div id="buildTab">
	<table class="container">
	<tr>
		<th>Версия</th>
		<th>Запущена</th>
		<th>Статус</th>
	</tr>
	{section name=i loop=$builds}
	<tr>
		<td><a traget="blanck" href="{$builds[i].webUrl}">{$builds[i].number}</a></td>
		<td>{$builds[i].startDate|date_format:$const.global.timeformat}</td>
		<td>
			<img src="{$factory->img_admin_dir}build_{$builds[i].status|lower}.gif" alt="{$builds[i].status}" title="{$builds[i].status}"/>
		</td>
	</tr>
	{/section}
</table>
</div>
{literal}
<script type="text/javascript">
	$(function() {
		$(".projectlink").click(function() {
			var reqdata = {
					'mode':'async', 
					'project': $(this).prop("id")
					};
		
			reload(reqdata);
		});

		$("#tabs").tabs();
	});
</script>
{/literal}
