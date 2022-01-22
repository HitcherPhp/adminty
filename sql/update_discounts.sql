
UPDATE discounts as d join promotions as p on p.id = d.promotion_id SET d.deleted=true WHERE STR_TO_DATE(d.end, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s') and p.perpetual = false;

UPDATE discounts SET deleted = false;
SELECT * FROM `discounts`;


update city_category_product as ccp
SET ccp.discount_id = null, ccp.promotion_ids = '-1';

update city_category_product as ccp
SET ccp.discount_id = null, ccp.promotion_ids = CONCAT('-1', ',', COALESCE(
(select GROUP_CONCAT(d.id ORDER BY d.id SEPARATOR ',') 
from (select * from discounts where ccp.city_id = city_id and FIND_IN_SET(ccp.id, product_ids) <> 0) as d join promotions as p on p.id = d.promotion_id 
where d.deleted = FALSE
and p.`type` in (SELECT DISTINCT `type` from promotions where deleted = false and perpetual = true)
and d.id = (select d.id from (select * from discounts where ccp.city_id = city_id and FIND_IN_SET(ccp.id, product_ids) <> 0) as ds join promotions as ps on ps.id = ds.promotion_id
where p.`type` = ps.`type`
ORDER BY ds.start DESC LIMIT 1)), ''))
where ccp.city_id in (1,2,3,4,5,6,7,8,9,10,11,12);

UPDATE city_category_product AS ccp
JOIN (select id, `start`, `end`, percent, product_ids, promotion_id, deleted
FROM discounts WHERE city_id in (1,2,3,4,5,6,7,8,9,10,11,12)) AS d 
ON FIND_IN_SET(ccp.id, d.product_ids) <> 0 
JOIN promotions as p on p.id = d.promotion_id
SET ccp.discount_id = d.id,
promotion_ids = CONCAT(COALESCE(ccp.promotion_ids, '-1'), ',', d.id)
WHERE ccp.published = true
and d.deleted = false
and p.perpetual = false
and p.deleted = false
and d.percent <> 0
and STR_TO_DATE(d.start, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
and STR_TO_DATE(d.end, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
and CONCAT(d.start, d.percent) = (select CONCAT(ds.start, ds.percent)
FROM (select id, `start`, `end`, percent, product_ids, promotion_id, deleted
FROM discounts where city_id in (1,2,3,4,5,6,7,8,9,10,11,12)) AS ds
JOIN promotions as ps on ps.id = ds.promotion_id
where FIND_IN_SET(ccp.id, ds.product_ids) <> 0
and ds.deleted = false
and ps.perpetual = false
and ps.deleted = false
and ds.percent <> 0
and STR_TO_DATE(ds.start, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
and STR_TO_DATE(ds.end, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
ORDER BY ds.start DESC, ds.percent DESC LIMIT 1);

-- update city_category_product as ccpm join (SELECT ccp.id as id, CONCAT(COALESCE(ccp.promotion_ids, '-1'), ',', GROUP_CONCAT(DISTINCT d.id ORDER BY d.id asc SEPARATOR ',')) as p_ids 
-- from city_category_product as ccp join (select id, `start`, `end`, perpetual, percent, product_ids, promotion_id, deleted from discounts where city_id in (1,2,3,4,5,6,7,8,9,10,11,12)) as d on FIND_IN_SET(ccp.id, d.product_ids) <> 0
-- join promotions as p on p.id = d.promotion_id
-- where ccp.published = true
-- and d.deleted = false
-- and p.deleted = false
-- and ((d.perpetual = true and d.percent = 0)
-- or (d.perpetual = false
-- and STR_TO_DATE(d.start, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
-- and STR_TO_DATE(d.end, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
-- and d.percent = 0 and d.start = (select dss.start from (select id, `start`, `end`, perpetual, percent, product_ids, promotion_id, deleted from discounts where city_id in (1,2,3,4,5,6,7,8,9,10,11,12)) as dss join promotions as pss on pss.id = dss.promotion_id
--                                      where FIND_IN_SET(ccp.id, dss.product_ids) <> 0 
--                                      and dss.deleted = false
--                                      and dss.perpetual = false
--                                   	 and pss.deleted = false
--                                      and dss.percent = 0
--                                      and STR_TO_DATE(dss.start, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
-- 								  	 and STR_TO_DATE(dss.end, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')
--                                      ORDER BY dss.start DESC LIMIT 1)))
-- GROUP BY ccp.id) as ccpa on ccpa.id = ccpm.id
-- SET ccpm.promotion_ids = ccpa.p_ids;

SELECT * FROM `city_category_product`;
