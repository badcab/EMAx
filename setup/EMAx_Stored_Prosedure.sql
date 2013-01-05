DELIMITER $$
DROP PROCEDURE IF EXISTS new_cost_of_event $$

CREATE PROCEDURE new_cost_of_event (IN eventID INT)
LANGUAGE SQL
DETERMINISTIC
SQL SECURITY DEFINER
BEGIN
	DECLARE optionVar, gradeVar, roomVar, newsumVar, outofcountyVar, basecostVar DECIMAL(6,2) UNSIGNED;
	DECLARE attendanceVar, roomResVar, countyVar INT;

	SET optionVar = SELECT SUM(`EMAx_Option`.`cost`) 
		FROM `EMAx_Option` 
		JOIN `EMAx_OptionEventMap`
		WHERE `EMAx_Option`.`ID` = `EMAx_OptionEventMap`.`EMAx_Option_ID`
		AND `EMAx_OptionEventMap`.`EMAx_Event_ID` = eventID;

	SET gradeVar = SELECT SUM(`EMAx_Grade`.`cost`) 
		FROM `EMAx_Grade` 
		JOIN `EMAx_GradeEventMap`
		WHERE `EMAx_Grade`.`ID` = `EMAx_GradeEventMap`.`EMAx_Grade_ID`
		AND `EMAx_GradeEventMap`.`EMAx_Event_ID` = eventID;

	SET newsumVar = optionVar + gradeVar ; 

	UPDATE `EMAx_Event` SET(`EMAx_Event`.`cost` = newsumVar) WHERE `EMAx_Event`.`ID` = eventID;
END
$$
DELIMITER ;