DELIMITER $$
DROP TRIGGER IF EXISTS login_fk_protection $$

CREATE TRIGGER login_fk_protection 
BEFORE DELETE 
ON EMAx_Login
FOR EACH ROW
BEGIN
	UPDATE `EMAx_Event` SET `EMAx_Login_ID` = NULL  WHERE `EMAx_Login_ID` = OLD.ID;
END
$$

DROP TRIGGER IF EXISTS organization_fk_protection $$

CREATE TRIGGER organization_fk_protection 
BEFORE DELETE 
ON EMAx_Organization
FOR EACH ROW 
BEGIN
	DELETE FROM `EMAx_Event` WHERE `EMAx_Organization_ID` = OLD.ID; 
	DELETE FROM `EMAx_Person` WHERE `EMAx_Organization_ID` = OLD.ID; 
END
$$

DROP TRIGGER IF EXISTS person_fk_protection $$

CREATE TRIGGER person_fk_protection 
BEFORE DELETE 
ON EMAx_Person
FOR EACH ROW
BEGIN
	UPDATE `EMAx_Event` SET `EMAx_Person_ID` = NULL WHERE `EMAx_Person_ID` = OLD.ID;
END
$$

DROP TRIGGER IF EXISTS grade_fk_protection $$

CREATE TRIGGER grade_fk_protection 
BEFORE DELETE 
ON EMAx_Grade
FOR EACH ROW
BEGIN	
	DELETE FROM `EMAx_GradeEventMap` WHERE `EMAx_GradeEventMap`.`EMAx_Grade_ID` = OLD.ID;
END
$$

DROP TRIGGER IF EXISTS option_fk_protection $$

CREATE TRIGGER option_fk_protection 
BEFORE DELETE 
ON EMAx_Option
FOR EACH ROW
BEGIN	
	DELETE FROM `EMAx_OptionEventMap` WHERE `EMAx_OptionEventMap`.`EMAx_Option_ID` = OLD.ID;
END
$$

DROP TRIGGER IF EXISTS roomLocation_fk_protection $$

CREATE TRIGGER roomLocation_fk_protection 
BEFORE DELETE 
ON EMAx_RoomLocation
FOR EACH ROW
BEGIN
	UPDATE `EMAx_Event` SET `EMAx_RoomLocation_ID` = NULL  WHERE `EMAx_RoomLocation_ID` = OLD.ID;
END
$$

DROP TRIGGER IF EXISTS event_fk_protection $$

CREATE TRIGGER event_fk_protection 
BEFORE DELETE 
ON EMAx_Event
FOR EACH ROW
BEGIN
	DELETE FROM `EMAx_OptionEventMap` WHERE `EMAx_OptionEventMap`.`EMAx_Event_ID` = OLD.ID;
	DELETE FROM `EMAx_GradeEventMap` WHERE `EMAx_GradeEventMap`.`EMAx_Event_ID` = OLD.ID;
END
$$
DELIMITER ;
