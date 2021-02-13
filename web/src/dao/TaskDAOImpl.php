<?php


namespace ru\timmson\FruitManagement\dao;

use Exception;

/**
 * Class TaskDAO
 * @package ru\timmson\FruitManagement\dao
 */
class TaskDAOImpl extends AbstractDAO implements TaskDAO
{

    /**
     * @return array
     */
    function getColumns(): array
    {
        return ["fm_user" => "string", "fm_name" => "string", "fm_project" => "string"];
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function findById(int $id): array
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, ["id" => $id], [])[0];
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function findByName(string $name) : array
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, ["fm_name" => $name], [])[0];
    }

    /**
     * @param array $filter
     * @param array $order
     * @return array
     * @throws Exception
     */
    public function findAll(array $filter = [], array $order = []): array
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, $filter, $order);
    }

    /**
     * @param array $filter
     * @param array $order
     * @return array
     * @throws Exception
     */
    public function findAllInProgress(array $filter = [], array $order = []): array
    {
        $query = "select * from v_task_in_progress";

        return $this->executeQuery($query, $filter, $order);
    }

    /**
     * @param string $user
     * @return array
     * @throws Exception
     */
    public function findAllBySubscribedUser(string $user): array
    {
        $query = "select t.* from v_task_all t, fm_subscribe s where s.fm_task = t.id and s.fm_user = '$user'";

        return $this->executeQuery($query, [], []);
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function findAllByParentId(int $id): array
    {
        $query = "select t.* from fm_relation r, v_task_all t where r.fm_parent = $id and r.fm_child = t.id order by t.fm_priority, t.id";

        return $this->executeQuery($query, [], []);
    }

    /**
     * @param int $id
     * @param int $fromId
     * @param int $toId
     * @throws Exception
     */
    public function changeParent(int $id, int $fromId, int $toId): void
    {
        $query = "update fm_relation set fm_parent=$toId where fm_parent=$fromId and fm_child=$id";
        $this->executeQuery($query, [], []);
    }

    /**
     * @param int $id
     * @param string $statusName
     * @throws Exception
     */
    public function updateStatus(int $id, string $statusName): void
    {
        $query = "update fm_task set fm_state = (select id from fm_state where fm_name = '$statusName') where id = $id";
        $this->executeQuery($query, [], []);
    }

    /**
     * @param array $task
     * @return array
     * @throws Exception
     */
    public function create(array $task): array
    {
        $query = "insert into fm_task(id, fm_name, fm_descr, fm_project, fm_state, fm_priority, fm_plan, fm_user) ";
        $query .= "values (null,";
        $query .= "'".$task['fm_name']."',";
        $query .= "'".$task['fm_descr']."',";
        $query .= $task['fm_project'].",";
        $query .= $task['fm_state'].",";
        $query .= $task['fm_priority'].",";
        $query .= $task['fm_plan'].",";
        $query .= "'".$task['fm_user']."')";
        $this->executeQuery($query, [], []);
        $task['id'] = $this->connection->getInsertId();
        return $task;
    }


}