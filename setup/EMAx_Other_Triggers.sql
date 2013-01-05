DELIMITER $$
DROP TRIGGER IF EXISTS option_price_change $$

CREATE TRIGGER option_price_change 
AFTER UPDATE
ON EMAx_Option
FOR EACH ROW
BEGIN
	DECLARE eventcostVar, newtotalVar DECIMAL(6,2) UNSIGNED;
	
	SET eventcostVar = SELECT `EMAx_Event`.`cost` 
		FROM `EMAx_Event`
		JOIN `` -- map opt
		WHERE
		AND
		AND
		AND `EMAx_Event`.`startTime` > NOW();
-- need to do the loop thing here	
	SET newtotalVar = eventcostVar + NEW.cost - OLD.cost;
 
END
$$
DELIMITER ;

-- ===================================== 

DELIMITER $$
DROP TRIGGER IF EXISTS grade_price_change $$

CREATE TRIGGER grade_price_change 
AFTER UPDATE
ON EMAx_Grade
FOR EACH ROW
BEGIN	
	
END
$$
DELIMITER ;

-- ===================================== 

DELIMITER $$
DROP TRIGGER IF EXISTS room_price_change $$

CREATE TRIGGER room_price_change 
AFTER UPDATE
ON EMAx_RoomLocation
FOR EACH ROW
BEGIN	
	
END
$$
DELIMITER ;
 
-- ===================================== 
 
DELIMITER $$
DROP TRIGGER IF EXISTS option_delete $$
CREATE TRIGGER option_delete 
AFTER DELETE 
ON EMAx_Option
FOR EACH ROW 
BEGIN
	CALL new_cost_of_event (); --need to get the events to pass into this
END
$$
DELIMITER ;

-- ===================================== 

DELIMITER $$
DROP TRIGGER IF EXISTS grade_delete $$
CREATE TRIGGER grade_delete 
AFTER DELETE
ON EMAx_Grade
FOR EACH ROW
BEGIN
	CALL new_cost_of_event (); --need to get the events to pass into this
END
$$
DELIMITER ;
 
-- ===================================== 

DELIMITER $$
DROP TRIGGER IF EXISTS room_delete $$
CREATE TRIGGER room_delete 
AFTER DELETE
ON EMAx_RoomLocation
FOR EACH ROW
BEGIN
	CALL new_cost_of_event (); --need to get the events to pass into this
END
$$
DELIMITER ;