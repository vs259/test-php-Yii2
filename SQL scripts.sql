CREATE TABLE `rubric` (
  `rubric_id` int(11) NOT NULL AUTO_INCREMENT,
  `rubric_title` varchar(100) NOT NULL DEFAULT '������� ��������',
  `parent_id` int(11)  NULL,
   PRIMARY KEY (`rubric_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('������� �� ������', null);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('��������', null);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('���� ������', null);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('�����', null);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('��������� �����', 2);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('������', 2);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('������', 3);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('������� ��������', 3);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('0-3 ����', 8);

INSERT INTO rubric
(rubric_title, parent_id)
VALUES('3-7 ���', 8);

CREATE TABLE news (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(100) NOT NULL DEFAULT '������� ��������� �������',
  news_text text NULL,
   PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `news_rubric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rubric_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_rubric_news_id_IDX` (`news_id`) USING BTREE,
  KEY `news_rubric_rubric_id_IDX` (`rubric_id`) USING BTREE,
  CONSTRAINT `news_rubric_news_FK` FOREIGN KEY (`news_id`) REFERENCES `news` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `news_rubric_rubric_FK` FOREIGN KEY (`rubric_id`) REFERENCES `rubric` (`rubric_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE news_rubric ADD CONSTRAINT news_rubric_UN UNIQUE KEY (rubric_id,news_id); -- �� ����� ���������� ���


INSERT INTO news
(news_title, news_text)
VALUES('� ������ ���������� �������� ������ �������� ���', '����� ������� � ������ �������� ��� ....');

INSERT INTO news_rubric
(rubric_id, news_id)
VALUES(5, 1);

INSERT INTO news
(news_title, news_text)
VALUES('������� �� ������� ������', '������� ������� �� ��������� ....');

INSERT INTO news_rubric
(rubric_id, news_id)
VALUES(5, 2);



-- ������ ���� ������
select * 
from rubric as r
;

-- ������ ��������
select * 
from news 
;

-- ����������
select * 
from news_rubric 
;

-- � ���� �������� ��������� �������
select r.*
from news as n
	right join news_rubric as nr
		on nr.news_id = n.news_id
	inner join rubric as r
		on r.rubric_id = nr.rubric_id
where n.news_id = 2
order by r.rubric_id
;

-- �������� ������
-- �� �������� �� �������� � WITH �.�. ������ mySQL ��� ���� 5,7
with recursive r as ( 
      select rubric_id, parent_id, rubric_title 
      from rubric 
      where rubric_id = 2 
      union 
      select d.rubric_id, d.parent_id, d.rubric_title 
      from rubric as d 
          inner join r 
              on d.parent_id = r.rubric_id 
  ) 
  select * from r 
  ; 

 
select  r.rubric_id, r.rubric_title, r.parent_id
from rubric as r
where r.rubric_id = 3
union 
select  rubric_id, rubric_title, parent_id
from    (select * from rubric
order by parent_id, rubric_id) as rubric_sorted,
(select @pv := 3) initialisation
where   find_in_set(parent_id, @pv)
and     length(@pv := concat(@pv, ',', rubric_id)) 
;


