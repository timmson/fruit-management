USE `fruit`;

-- Dictionaries

-- fm_priority --
INSERT INTO `fm_priority` (id, fm_name, fm_descr) VALUES(1, 'high', 'High');
INSERT INTO `fm_priority` (id, fm_name, fm_descr) VALUES(2, 'medium', 'Medium');
INSERT INTO `fm_priority` (id, fm_name, fm_descr) VALUES(3, 'low', 'Low');

-- fm_state --
INSERT INTO `fm_state` (id, fm_name, fm_descr, fm_next_state) VALUES(1, 'new', 'New', 2);
INSERT INTO `fm_state` (id, fm_name, fm_descr, fm_next_state) VALUES(2, 'planned', 'Planned', 3);
INSERT INTO `fm_state` (id, fm_name, fm_descr, fm_next_state) VALUES(3, 'in_progress', 'In progress', 5);
INSERT INTO `fm_state` (id, fm_name, fm_descr, fm_next_state) VALUES(4, 'decline', 'Decline', NULL);
INSERT INTO `fm_state` (id, fm_name, fm_descr, fm_next_state) VALUES(5, 'test', 'Testing', 6);
INSERT INTO `fm_state` (id, fm_name, fm_descr, fm_next_state) VALUES(6, 'done', 'Done', NULL);

-- fm_cat_log
INSERT INTO `fm_cat_log` (id, fm_name, fm_descr) VALUES(1, 'log', 'Logging');
INSERT INTO `fm_cat_log` (id, fm_name, fm_descr) VALUES(2, 'cmnt', 'Comments');
INSERT INTO `fm_cat_log` (id, fm_name, fm_descr) VALUES(3, 'url', 'Link');
INSERT INTO `fm_cat_log` (id, fm_name, fm_descr) VALUES(4, 'est', 'Estimation');


-- fm_projects
INSERT INTO `fm_project` VALUES (1, 'REL', 'Release project', 'manager', NULL);
INSERT INTO `fm_project` VALUES (2, 'SAMPLE', 'Some new project', 'manager', NULL);

-- fm_tasks
INSERT INTO `fm_task` VALUES (1, 'RFC', 'Release 1', 1, 3, 2, 100, 'fruit');
INSERT INTO `fm_task` VALUES (2, 'Some', 'work', 2, 3, 2, 100, 'fruit');
INSERT INTO `fm_task` VALUES (3, 'Some', 'work', 2, 3, 2, 100, 'vegetble');

-- fm_relation
INSERT INTO `fm_relation` VALUES (1, 0, 0);
INSERT INTO `fm_relation` VALUES (2, 1, 2);