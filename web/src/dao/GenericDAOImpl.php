<?php


namespace ru\timmson\FruitManagement\dao;


class GenericDAOImpl extends AbstractDAO implements GenericDAO
{

    /**
     * @inheritDoc
     */
    protected function getColumns(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getActivity(string $user): array
    {
        $query = "select * from (select l.*, datediff(curdate(), fm_date) as fm_days_ago, t.fm_name, t.fm_descr from fm_work_log l, v_task_all t where t.id = l.fm_task and l.fm_user <> '$user' order by l.fm_date desc, l.id desc)   a where a.fm_days_ago > -1 and a.fm_days_ago < 5 limit 15";

        return $this->executeQuery($query, [] , []);
    }
}